<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="mu-toolbar">

            <div class="mu-search">
                <i class="ti ti-search"></i>

                <input type="text"
                    id="muSearch"
                    placeholder="Cari nama, email, role, atau tim...">

                <button type="button"
                    id="muSearchClear"
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tim Kerja</th>
                    </tr>
                </thead>

                <tbody id="muTableBody">
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Memuat...
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

    <div class="ar-table-bottom">

        <div class="ar-table-info">

            <select id="muPerPage" class="ar-perpage">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>

            <div class="ar-info-text" id="muInfo">
                Menampilkan 0 data
            </div>

        </div>

        <div class="ar-pagination">
            <ul class="pagination mb-0" id="muPagination"></ul>
        </div>

    </div>
</div>