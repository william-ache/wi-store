<template x-if="canRunSearch() && flatSearchRows().length > 0">
    <div class="p-1.5 space-y-0.5">
        <template x-for="row in flatSearchRows()" :key="row.key">
            <button type="button"
                    @click="handleSearchSelect(row.type, row.item)"
                    class="admin-search-result w-full flex items-center gap-2.5 text-left px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors group cursor-pointer">
                <div class="shrink-0">
                    <template x-if="row.type === 'product' && row.item.image_path">
                        <img :src="row.item.image_path.startsWith('http') ? row.item.image_path : '/storage/' + row.item.image_path"
                             class="admin-search-result__icon admin-search-result__icon--image"
                             alt="">
                    </template>
                    <template x-if="row.type !== 'product' || !row.item.image_path">
                        <div class="admin-search-result__icon" :class="'admin-search-result__icon--' + row.badgeTone">
                            <template x-if="row.type === 'category'">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                            </template>
                            <template x-if="row.type === 'product'">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            </template>
                            <template x-if="row.type === 'order'">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            </template>
                            <template x-if="row.type === 'client'">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate" x-text="row.title"></p>
                    <p class="text-[10px] font-medium text-slate-500 dark:text-slate-400 truncate mt-0.5" x-text="row.subtitle"></p>
                </div>
                <span class="admin-search-badge shrink-0 inline-flex"
                      :class="'admin-search-badge--' + row.badgeTone"
                      x-text="row.badge"></span>
            </button>
        </template>
    </div>
</template>

<template x-if="canRunSearch() && !hasSearchResults() && !searchLoading">
    <div class="p-6 text-center text-xs text-slate-400 font-bold">
        No se encontraron resultados
    </div>
</template>
