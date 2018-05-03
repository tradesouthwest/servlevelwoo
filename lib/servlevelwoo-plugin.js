 (function($){
                $(function(){
                    $('div.woocommerce').on( 'change', '.price_info', function(){
                        $("[name='update_cart']").trigger('click');
                    });
                });
            })(jQuery);
