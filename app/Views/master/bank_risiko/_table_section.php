<div class="card border-0 shadow-sm" id="brTableCard">
    <div class="card-body">
        <div class="br-toolbar">

            <div class="br-search">
                <i class="ti ti-search"></i>

                <input
                    type="text"
                    id="brSearch"
                    placeholder="Cari pernyataan risiko...">

                <button
                    type="button"
                    id="brSearchClear"
                    class="d-none">
                    <i class="ti ti-x"></i>
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Pernyataan Risiko</th>
                        <!-- <th>Status</th> -->
                    </tr>
                </thead>

                <tbody id="brTableBody">
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">Memuat...</td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

    <div class="ar-table-bottom">

        <div class="ar-table-info">
            <select id="brPerPage" class="ar-perpage">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>

            <div class="ar-info-text" id="brInfo">Menampilkan 0 data</div>
        </div>

        <div class="ar-pagination">
            <ul class="pagination mb-0" id="brPagination"></ul>
        </div>

    </div>

</div>