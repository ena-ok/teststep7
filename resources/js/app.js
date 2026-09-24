import './bootstrap';

import $ from 'jquery';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.$ = $;

Alpine.start();

if (document.getElementById('product-list')) {

    let currentSort = 'id';
    let currentDirection = 'desc';
    let currentPage = 1;

    const searchForm = document.getElementById('search-form');
    const productsUrl = searchForm.dataset.url;


    function fetchProducts(page = 1) {

        currentPage = page;

        const params = new URLSearchParams({
            keyword: document.querySelector('[name="keyword"]').value,
            company_id: document.querySelector('[name="company_id"]').value,
            price_min: document.querySelector('[name="price_min"]').value,
            price_max: document.querySelector('[name="price_max"]').value,
            stock_min: document.querySelector('[name="stock_min"]').value,
            stock_max: document.querySelector('[name="stock_max"]').value,
            sort: currentSort,
            direction: currentDirection,
            page: page
        });

        $.ajax({
            url: `${productsUrl}?${params.toString()}`,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },

            success: function (data) {

                let html = '';

                if (data.products.data.length === 0) {

                    html = `
                        <tr>
                            <td colspan="7" class="text-muted">
                                商品が見つかりません。
                            </td>
                        </tr>
                    `;

                } else {

                    data.products.data.forEach(product => {

                        const imageHtml = product.img_path
                            ? `<img src="/storage/${product.img_path}"
                                    alt="商品画像"
                                    width="60">`
                            : '画像なし';

                        html += `
                            <tr id="product-${product.id}">
                                <td>${product.id}</td>

                                <td>${imageHtml}</td>

                                <td>${product.name}</td>

                                <td>¥${Number(product.price).toLocaleString()}</td>

                                <td>${product.stock}</td>

                                <td>
                                    ${product.company
                                        ? product.company.company_name
                                        : '不明'}
                                </td>

                                <td>
                                    <a href="/products/${product.id}"
                                       class="btn btn-info btn-sm text-white">
                                        詳細
                                    </a>

                                    <form action="/products/${product.id}"
                                          method="POST"
                                          class="d-inline delete-form">

                                        <input type="hidden"
                                               name="_token"
                                               value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">

                                        <input type="hidden"
                                               name="_method"
                                               value="DELETE">

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `;
                    });
                }

                $('#product-list').html(html);

                renderPagination(data.products.links);
            },

            error: function (xhr) {
                console.error('商品取得エラー:', xhr);
                alert('商品の取得に失敗しました。');
            }
        });
    }


    function renderPagination(links) {

        let html = '<nav><ul class="pagination">';

        links.forEach(link => {

            if (!link.url) {

                html += `
                    <li class="page-item disabled">
                        <span class="page-link">
                            ${convertPaginationLabel(link.label)}
                        </span>
                    </li>
                `;

                return;
            }

            const url = new URL(link.url);
            const page = url.searchParams.get('page');

            html += `
                <li class="page-item ${link.active ? 'active' : ''}">
                    <a href="${link.url}"
                       class="page-link"
                       data-page="${page}">
                        ${convertPaginationLabel(link.label)}
                    </a>
                </li>
            `;
        });

        html += '</ul></nav>';

        $('#pagination').html(html);
    }


    function convertPaginationLabel(label) {

        return label
            .replace('&laquo; Previous', '« Previous')
            .replace('Next &raquo;', 'Next »');
    }


    // ページネーション
    $(document).on('click', '#pagination a', function (event) {

        event.preventDefault();

        let page = $(this).data('page');

        if (!page) {
            const url = new URL($(this).attr('href'), window.location.origin);
            page = url.searchParams.get('page');
        }

        fetchProducts(page);
    });


    // 検索
    $('#search-form').on('submit', function (event) {

        event.preventDefault();

        fetchProducts(1);
    });


    // ソート
    $('.sortable').on('click', function () {

        const sort = $(this).data('sort');

        if (currentSort === sort) {

            currentDirection =
                currentDirection === 'asc'
                    ? 'desc'
                    : 'asc';

        } else {

            currentSort = sort;
            currentDirection = 'asc';
        }

        fetchProducts(1);
    });


    // 削除
    $(document).on('submit', '.delete-form', function (event) {

        event.preventDefault();

        const form = this;

        if (!confirm('この商品を削除しますか？')) {
            return;
        }

        $.ajax({
            url: form.action,
            type: 'POST',

            data: {
                _token: form.querySelector('[name="_token"]').value,
                _method: 'DELETE'
            },

            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },

            success: function () {

                const row = form.closest('tr');

                if (row) {
                    row.remove();
                }
            },

            error: function (xhr) {

                console.error('削除エラー:', xhr);

                alert('商品の削除に失敗しました。');
            }
        });
    });
}