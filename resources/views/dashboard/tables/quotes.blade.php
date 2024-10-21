<table class="main-table">
    {{-- Head start --}}
    <thead>
        <tr>
            <x-dashboard.table.th.select-all />
            <x-dashboard.table.th.edit />

            <th width="220">
                <x-dashboard.table.th.order-link order-by="author_id" text="Автор" />
            </th>

            <th>Цитата</th>

            <th width="200">Категории</th>

            <th width="220">
                <x-dashboard.table.th.order-link order-by="notes" text="Мысли автора" />
            </th>

            <th width="170">
                <x-dashboard.table.th.order-link order-by="publish_at" text="Опубликовано" />
            </th>

            <th width="140">Действие</th>
        </tr>
    </thead> {{-- Head end --}}
</table>
