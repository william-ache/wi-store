<?php

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BillingPaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that expired shop admins are blocked and redirected to billing page.
     */
    public function test_expired_shop_admin_is_redirected_to_expired_page(): void
    {
        $shop = Shop::create([
            'name' => 'Expired Shop',
            'slug' => 'expired-shop',
            'whatsapp_number' => '1234567890',
            'color_primary' => '#8B5CF6',
            'color_secondary' => '#0a051d',
            'color_background' => '#0b0f19',
            'plan' => 'free_trial',
            'plan_expires_at' => now()->subDay(), // Expired yesterday
        ]);

        $user = User::create([
            'name' => 'Store Admin',
            'email' => 'admin@expiredshop.com',
            'password' => bcrypt('password'),
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($user)
            ->get("/{$shop->slug}/admin/dashboard");

        $response->assertRedirect("/{$shop->slug}/admin/billing/expired");
    }

    /**
     * Test payment submission with the new company name and company email fields.
     */
    public function test_payment_submission_validates_and_stores_new_company_fields(): void
    {
        Storage::fake('public');

        $shop = Shop::create([
            'name' => 'Expired Shop',
            'slug' => 'expired-shop',
            'whatsapp_number' => '1234567890',
            'color_primary' => '#8B5CF6',
            'color_secondary' => '#0a051d',
            'color_background' => '#0b0f19',
            'plan' => 'free_trial',
            'plan_expires_at' => now()->subDay(),
        ]);

        $user = User::create([
            'name' => 'Store Admin',
            'email' => 'admin@expiredshop.com',
            'password' => bcrypt('password'),
            'shop_id' => $shop->id,
        ]);

        $receipt = UploadedFile::fake()->image('receipt.png');

        // Test missing fields validation
        $response = $this->actingAs($user)
            ->post("/{$shop->slug}/admin/billing/pay", [
                'plan' => 'premium',
                'billing_cycle' => 'mensual',
                'payment_reference' => '123456',
                'payment_receipt' => $receipt,
                // Missing payment_company_name and payment_company_email
            ]);

        $response->assertSessionHasErrors(['payment_company_name', 'payment_company_email']);

        // Test valid submission
        $response = $this->actingAs($user)
            ->post("/{$shop->slug}/admin/billing/pay", [
                'plan' => 'premium',
                'billing_cycle' => 'mensual',
                'payment_reference' => '12345678',
                'payment_receipt' => $receipt,
                'payment_company_name' => 'Wydex Venezuela C.A.',
                'payment_company_email' => 'contacto@wydex.net',
            ]);

        $response->assertRedirect();
        $this->assertEquals('pending', $shop->fresh()->payment_status);
        $this->assertEquals('Wydex Venezuela C.A.', $shop->fresh()->payment_company_name);
        $this->assertEquals('contacto@wydex.net', $shop->fresh()->payment_company_email);
        $this->assertEquals('12345678', $shop->fresh()->payment_reference);
        $this->assertNotNull($shop->fresh()->payment_receipt_path);
    }

    /**
     * Test that the expired page shows pending details after successful submission.
     */
    public function test_expired_page_displays_pending_company_details(): void
    {
        $shop = Shop::create([
            'name' => 'Pending Shop',
            'slug' => 'pending-shop',
            'whatsapp_number' => '1234567890',
            'color_primary' => '#8B5CF6',
            'color_secondary' => '#0a051d',
            'color_background' => '#0b0f19',
            'plan' => 'premium',
            'billing_cycle' => 'mensual',
            'plan_expires_at' => now()->subDay(),
            'payment_status' => 'pending',
            'payment_reference' => '98765432',
            'payment_company_name' => 'Custom Company L.T.D.',
            'payment_company_email' => 'support@customcomp.com',
            'payment_receipt_path' => 'receipts/test.png',
        ]);

        $user = User::create([
            'name' => 'Store Admin',
            'email' => 'admin@pendingshop.com',
            'password' => bcrypt('password'),
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($user)
            ->get("/{$shop->slug}/admin/billing/expired");

        $response->assertStatus(200);
        $response->assertSee('El pago se está confirmando');
        $response->assertSee('Custom Company L.T.D.');
        $response->assertSee('support@customcomp.com');
        $response->assertSee('98765432');
        $response->assertSee('Notificar por WhatsApp');
    }

    /**
     * Test that Super Admin can approve the payment, extending subscription and cleaning payment fields.
     */
    public function test_super_admin_can_approve_payment(): void
    {
        $shop = Shop::create([
            'name' => 'Pending Shop',
            'slug' => 'pending-shop',
            'whatsapp_number' => '1234567890',
            'color_primary' => '#8B5CF6',
            'color_secondary' => '#0a051d',
            'color_background' => '#0b0f19',
            'plan' => 'free_trial',
            'plan_expires_at' => now()->subDay(),
            'payment_status' => 'pending',
            'pending_plan' => 'premium',
            'pending_billing_cycle' => 'anual',
            'payment_reference' => '98765432',
            'payment_company_name' => 'Custom Company L.T.D.',
            'payment_company_email' => 'support@customcomp.com',
            'payment_receipt_path' => 'receipts/test.png',
        ]);

        // Simulating super admin authenticated session
        $response = $this->withSession(['super_admin_authenticated' => true])
            ->post("/wydex-super-admin/payments/{$shop->id}/approve");

        $response->assertRedirect();
        
        $shop = $shop->fresh();
        $this->assertEquals('none', $shop->payment_status);
        $this->assertEquals('premium', $shop->plan);
        $this->assertEquals('anual', $shop->billing_cycle);
        $this->assertNull($shop->payment_company_name);
        $this->assertNull($shop->payment_company_email);
        $this->assertNull($shop->payment_reference);
        $this->assertNull($shop->payment_receipt_path);
        $this->assertEquals(now()->addDays(365)->format('Y-m-d'), $shop->plan_expires_at->format('Y-m-d'));
    }
}
