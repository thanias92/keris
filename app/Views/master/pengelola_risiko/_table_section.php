<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="pr-toolbar">

            <div class="pr-search">
                <i class="ti ti-search"></i>

                <input type="text"
                    id="prSearch"
                    placeholder="Cari nama, NIP atau jabatan...">

                <button type="button"
                    id="prSearchClear"
                    class="d-none">
                    <i class="ti ti-x"></i>
                </button>
            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Wilayah</th>
                        <th>Pemilik Risiko</th>
                        <th>Aktif</th>
                    </tr>
                </thead>

                <tbody id="prTableBody">
                    <tr>
                        <td colspan="7"
                            class="text-center py-4 text-muted">
                            Memuat...
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

    <div class="ar-table-bottom">

        <div class="ar-table-info">

            <select id="prPerPage" class="ar-perpage">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>

            <div class="ar-info-text" id="prInfo">
                Menampilkan 0 data
            </div>

        </div>

        <div class="ar-pagination">
            <ul class="pagination mb-0" id="prPagination"></ul>
        </div>

    </div>

</div>