<div class="card border-0 shadow-sm" id="tkTableCard">
    <div class="card-body">
        <div class="tk-toolbar">

            <div class="tk-search">

                <i class="ti ti-search"></i>

                <input
                    type="text"
                    id="tkSearch"
                    placeholder="Cari tim kerja atau kegiatan...">

                <button
                    type="button"
                    id="tkSearchClear"
                    class="d-none">

                    <i class="ti ti-x"></i>

                </button>

            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="tk-col-no">#</th>
                        <th class="tk-col-tim">Tim Kerja</th>
                        <th class="tk-col-kegiatan">Kegiatan</th>
                    </tr>
                </thead>
                <tbody id="tkTableBody">
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">Memuat...</td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

    <div class="ar-table-bottom">

        <div class="ar-table-info">
            <select id="tkPerPage" class="ar-perpage">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>

            <div class="ar-info-text" id="tkInfo">Menampilkan 0 data</div>
        </div>

        <div class="ar-pagination">
            <ul class="pagination mb-0" id="tkPagination"></ul>
        </div>

    </div>

</div>