<!-- Index scripts -->

<script type="text/javascript">

        // $.getScript("https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&amp;callback=initialize&amp;language=en&amp;key=AIzaSyApbQ2FwluM5P4SLKdso5Vkk8zuLTnOzQI");

        function initialize() {
            $("#addr_from, #addr_to").autocomplete({
                autoFocus: true,
                minLength: 1
            }, {
                source: function(request, response) {
                    var input = $(this.element).val();
                    $.ajax({
                        type: 'POST',
                        url: 'https://www.LogistiQuote2.com/search/google-autocomplete',
                        dataType: 'json',
                        data: {
                            input: input
                        },
                        mode: 'abort',
                        minLength: 2,
                        success: function(data) {
                            $('.ui-autocomplete-input').removeClass('ui-autocomplete-loading');
                            response(data);
                        }
                    });
                },
                change: function(event, ui) {
                    if (ui.item == undefined) {
                        $(this).parent().find('[name="from"], [name="to"]').val('');
                        $(this).val('');
                    }
                },
                select: function(event, ui) {
                    var oldThis = this;
                    $.ajax({
                        type: 'POST',
                        url: 'https://www.LogistiQuote2.com/search/google-geocode',
                        dataType: 'json',
                        data: {
                            input: ui.item.place_id,
                            type: 'place_id'
                        },
                        mode: 'abort',
                        success: function(result) {
                            $.map(result.results, function(item) {
                                var a_c = item.address_components;
                                var country = a_c[a_c.length - 1];
                                for (var i in a_c) {
                                    if ($.inArray('country', a_c[i]['types']) != -1 && $.inArray('political', a_c[i]['types']) != -1) country = a_c[i];
                                }
                                if (!isNaN(parseInt(country.short_name))) country.short_name = (country.short_name >= 95000 && country.short_name <= 99804 ? 'UA' : country.short_name);
                                $(oldThis).parent().find('[name="from"], [name="to"]').val(ui.item.place_id).trigger('change');;
                                $(oldThis).val(ui.item.city + ', ' + ((ui.item.region != null) ? (ui.item.region + ', ') : '') + ui.item.country);
                                return {
                                    country_code: country.short_name,
                                    city_name: a_c[0].long_name,
                                    label: item.formatted_address,
                                    value: item.formatted_address,
                                    latitude: item.geometry.location.lat,
                                    longitude: item.geometry.location.lng,
                                    place_id: item.place_id
                                };
                            })
                        }
                    });
                }
            }).each(function() {
                $(this).data("ui-autocomplete")._renderItem = function(ul, item) {
                    $('.ui-autocomplete-input').removeClass('ui-autocomplete-loading');
                    var htm = '<i class="flag-icon flag-icon-' + item.counrty_code.toLowerCase() + '"></i><a>' + item.city + ', ' + ((item.region != null) ? (item.region + ', ') : '') + item.country + "</a>";
                    return $("<li></li>").data("item.autocomplete", item).append(htm).appendTo(ul);
                };
            });
        }
        $(document).ready(function() 
        {
            $('.btn-route').on('click', function() {
                $('.route-active').removeClass('route-active');
                $(this).addClass('route-active');
                var mode = $(this).data('mode');
                $('.dropdown-shipment li').hide();
                $('.dropdown-shipment li:has([data-mode="' + mode + '"])').show().find('a').first().click();
                var type = $(this).data('type');
                console.log( $(this).data().mode );
                $("#transportation_type").val( $(this).data().mode );
                $('.type-delivery-active').removeClass('type-delivery-active');
                $('.type-' + type + '-item').addClass('type-delivery-active');
            });
            $('.route-list [data-mode="sea"]').click();
            $('.dropdown-shipment li > a').on('click', function() {
                CURRENT_MODE = $(this).data('mode');
                CURRENT_TYPE = $(this).data('type');
                var angle = (CURRENT_TYPE === 'air' || CURRENT_TYPE === 'rail') ? '' : '<i class="fal fa-angle-down"></i>';
                $('#weight_cargo').val(CURRENT_TYPE === 'bulk' ? 1 : 100);
                $('.dropdown-shipment > a').html($(this).html() + angle);
                var type = $(this).data('type');
                $('.filter-shipping [name="type"]').val(type);
            });
            let date_filter = new Date();
            let date_before = date_filter > new Date() ? new Date() : date_filter;
            $('.date-day').datepicker({
                autoclose: true,
                container: '.date-field',
                startDate: date_before
            }).datepicker('update', date_filter);
            $('.application-switch ul').on('click', 'li', function(event) {
                $(this).addClass('active').siblings().removeClass('active');
                if ($(this).hasClass('switch-freight')) {
                    $('.filter-shipping, .title-shipping', ).addClass('active');
                    $('.filter-tracking, .title-tracking').removeClass('active');
                } else {
                    $('.filter-shipping, .title-shipping').removeClass('active');
                    $('.filter-tracking, .title-tracking').addClass('active');
                }
            });
            $('.swap-places').on('click', function() {
                var addr = $('#addr_from').val();
                var id = $('#addr_from_id').val();
                var lat = $('#lat_from').val();
                var lng = $('#lng_from').val();
                $('#addr_from').val($('#addr_to').val());
                $('#addr_from_id').val($('#addr_to_id').val());
                $('#lat_from').val($('#lat_to').val());
                $('#lng_from').val($('#lng_to').val());
                $('#addr_to').val(addr);
                $('#addr_to_id').val(id);
                $('#lat_to').val(lat);
                $('#lng_to').val(lng);
            });
            $('#select-two').select2();
        }); 
    </script>
<!-- ! Index scripts -->