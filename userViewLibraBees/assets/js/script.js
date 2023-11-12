(() => {

    $(".card-header").on("click", (e) => {
        const t = $(e.target); // t = this
        const cardBody = t.next(".card-body");
        const cardToolbar = t.find("> .card-toolbar");
    
        if (cardToolbar.hasClass("drop-inactive")) {
            cardToolbar.addClass("drop-active").removeClass("drop-inactive");
            cardBody.slideDown();
        } else {
            cardToolbar.addClass("drop-inactive").removeClass("drop-active");
            cardBody.slideUp();
        }
    });
    
    $('input[type=checkbox]').on("click", () => filterProduct(1));
    $("input#searchKeyword").on('keyup input', () => filterProduct(1));
    $(document).on('click', '.page-link', (e) => filterProduct($(e.currentTarget).data("page")));
    
    const checkboxFilter = selector => {
        const filter = [];
        $('[data-filter=' + selector + ']:checked').each(function () {
            filter.push($(this).val());
        });
        return filter;
    }
    
    const filterProduct = page => {
        const bk_subj = checkboxFilter('bk_subj');
        const bk_cat = checkboxFilter('bk_cat');
        const bk_sec = checkboxFilter('bk_sec');
        const searchKeyword = $('#searchKeyword').val();
        $.ajax({
            url: "process.php",
            method: "POST",
            data: {
                page: page,
                bk_subj: bk_subj,
                bk_cat: bk_cat,
                bk_sec: bk_sec,
                searchKeyword: searchKeyword
            },
            beforeSend:function () {
                $("#productsContainer").html(`<div class="card min-h-400px col-lg-12">
                                            <div class="card-body justify-align-center">
                                                <div class="spinner-border" role="status"></div>
                                            </div>
                                        </div>`);
                $("#pagination").html('');
            },
            success: function (res) {
                try {
                    
                    res = JSON.parse(res)
                    const products = res.products;
                    const pagination = res.pagination;
                    $("#productsContainer").html(products);
                    $("#pagination").html(pagination);
                } catch (e) {
                    alert(e);
                }
            },
            error: function () {
                alert("Error in sending request");
            }
        })
    }
    filterProduct(1);
    
})();


