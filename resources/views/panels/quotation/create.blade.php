@extends('panels.layouts.master')
@section('content')
<style>
    /*------------------------*/
    input:focus,
    button:focus,
    .form-control:focus {
        outline: none;
        box-shadow: none;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #fff;
    }

    /*----------step-wizard------------*/
    .d-flex {
        display: flex;
    }

    .justify-content-center {
        justify-content: center;
    }

    .align-items-center {
        align-items: center;
    }

    /*---------signup-step-------------*/
    .bg-color {
        background-color: #333;
    }

    .signup-step-container {
        padding: 150px 0px;
        padding-bottom: 60px;
    }

    span.round-tab {
        width: 30px;
        height: 30px;
        line-height: 30px;
        display: inline-block;
        border-radius: 50%;
        background: #fff;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 16px;
        color: #0e214b;
        font-weight: 500;
        border: 1px solid #ddd;
    }

    span.round-tab i {
        color: #555555;
    }

    .tab-pane {
        display: none;
    }
    .tab-pane.active {
        display: block;
    }

    .prev-step,
    .next-step {
        font-size: 13px;
        padding: 8px 24px;
        border: none;
        border-radius: 4px;
        background-color: #6c757d;
        color: #fff;
    }

    .next-step {
        color: #fff;
        background-color: #007bff;
    }

    .step-head {
        font-size: 20px;
        text-align: center;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .term-check {
        font-size: 14px;
        font-weight: 400;
    }

    .custom-file {
        position: relative;
        display: inline-block;
        width: 100%;
        height: 40px;
        margin-bottom: 0;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 40px;
        margin: 0;
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: 40px;
        padding: .375rem .75rem;
        font-weight: 400;
        line-height: 2;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: 38px;
        padding: .375rem .75rem;
        line-height: 2;
        color: #495057;
        content: "Browse";
        background-color: #e9ecef;
        border-left: inherit;
        border-radius: 0 .25rem .25rem 0;
    }

    .footer-link {
        margin-top: 30px;
    }

    .all-info-container {}

    .list-content {
        margin-bottom: 10px;
    }

    .list-content a {
        padding: 10px 15px;
        width: 100%;
        display: inline-block;
        background-color: #f5f5f5;
        position: relative;
        color: #565656;
        font-weight: 400;
        border-radius: 4px;
    }

    .list-content a[aria-expanded="true"] i {
        transform: rotate(180deg);
    }

    .list-content a i {
        text-align: right;
        position: absolute;
        top: 15px;
        right: 10px;
        transition: 0.5s;
    }

    .form-control[disabled],
    .form-control[readonly],
    fieldset[disabled] .form-control {
        background-color: #fdfdfd;
    }

    .list-box {
        padding: 10px;
    }

    .signup-logo-header .logo_area {
        width: 200px;
    }

    .signup-logo-header .nav>li {
        padding: 0;
    }

    .signup-logo-header .header-flex {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .list-inline li {
        display: inline-block;
    }

    .pull-right {
        float: right;
    }

    /*-----------custom-checkbox-----------*/
    /*----------Custom-Checkbox---------*/
    input[type="checkbox"] {
        position: relative;
        display: inline-block;
        margin-right: 5px;
    }

    input[type="checkbox"]::before,
    input[type="checkbox"]::after {
        position: absolute;
        content: "";
        display: inline-block;
    }

    input[type="checkbox"]::before {
        height: 16px;
        width: 16px;
        border: 1px solid #999;
        left: 0px;
        top: 0px;
        background-color: #fff;
        border-radius: 2px;
    }

    input[type="checkbox"]::after {
        height: 5px;
        width: 9px;
        left: 4px;
        top: 4px;
    }

    input[type="checkbox"]:checked::after {
        content: "";
        border-left: 1px solid #fff;
        border-bottom: 1px solid #fff;
        transform: rotate(-45deg);
    }

    input[type="checkbox"]:checked::before {
        background-color: #18ba60;
        border-color: #18ba60;
    }






    @media (max-width: 767px) {
        .sign-content h3 {
            font-size: 40px;
        }

        .signup-logo-header .navbar-toggle {
            margin: 0;
            margin-top: 8px;
        }

        .signup-logo-header .logo_area {
            margin-top: 0;
        }

        .signup-logo-header .header-flex {
            display: block;
        }
    }

</style>

<section>
    <div class="container">
        @include('panels.includes.errors')

        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="wizard">
                    @component('components.wizard', ['steps' => [
                        ['id' => 'step1', 'title' => 'Basic'],
                        ['id' => 'step2', 'title' => 'Description'],
                    ]])
                    @endcomponent

                    <form role="form" action="{{ route('quotation.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content mb-3" id="main_form">
                            @include('panels.quotation.steps.step1')
                            @include('panels.quotation.steps.step2')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('bottom_scripts')
<script>
    $(document).ready(function () {

        // Dynamic changes
        $(document).on('keyup', "input[name^='l'], input[name^='w'], input[name^='h']", function () {
            $el = $(this);
            $unit_num = $el.parent().parent().parent();
            if ($unit_num.find("input[name^='l']").val() && $unit_num.find("input[name^='w']").val() &&
                $unit_num.find("input[name^='h']").val()) {
                let l = $unit_num.find("input[name^='l']").val();
                let w = $unit_num.find("input[name^='w']").val();
                let h = $unit_num.find("input[name^='h']").val();
                let total_weight = (l * w * h) / 6000;
                $unit_num.find("input[name^='total_weight_units']").val(total_weight.toFixed(2));
            }
        });

        $('#exw').hide();
        $('#dynamic_buttons').show();
        $('.dynamic-field').show();

        $('#shipment').hide();
        $("input[name=quantity]").prop('', false);
        $("input[name=total_weight]").prop('', false);

        // On load
        if ($("#transportation_type").find(':selected').val() === 'ocean') {
            $('#type_of_shipment').empty();
            $("#type_of_shipment").append(new Option("LCL", "lcl"));
            $("#type_of_shipment").append(new Option("FCL", "fcl"));
        } else if ($("#transportation_type").find(':selected').val() === 'air') {
            $('#type_of_shipment').empty();
            $("#type_of_shipment").append(new Option("AIR", "air"));
        }

        // On calculation radio button clicks
        $('input:radio').change(function () {
            let el = $(this).val();
            if (el === 'units') {
                $('#dynamic_buttons').show();
                $('.dynamic-field').show();
                $(".require").prop('', true);

                $('#shipment').hide();
                $("input[name=quantity]").prop('', false);
                $("input[name=total_weight]").prop('', false);
            } else {
                $('.dynamic-field').hide();
                $('#dynamic_buttons').hide();
                $('#shipment').show();

                $(".require").prop('', false);
            }
        });

        // Live results on calculations
        $("input[name=quantity_units], input[name=total_weight_units], input[name=l], input[name=w], input[name=h]")
            .keyup(function () {
                let quantity = $('input[name=quantity_units]').val() ? parseFloat($(
                    'input[name=quantity_units]').val()) : 1;
                let l = $('input[name=l]').val() ? parseFloat($('input[name=l]').val()) : 1;
                let w = $('input[name=w]').val() ? parseFloat($('input[name=w]').val()) : 1;
                let h = $('input[name=h]').val() ? parseFloat($('input[name=h]').val()) : 1;

                let total_weight = (l * w * h) / 6000 * quantity;
                $('input[name=total_weight_units]').val(total_weight);
            });


        // On Incoterms button clicks
        $('#incoterms').change(function () {
            let el = $(this).val();
            if (el === 'EXW') {
                $('#exw').show();
                $("input[name=pickup_address]").prop('', true);
                $("input[name=final_destination_address]").prop('',
                    true);
            } else {
                $('#exw').hide();
                $("input[name=pickup_address]").prop('', false);
                $("input[name=final_destination_address]").prop('',
                    false);
            }
        });

    });
</script>

<!-- Add dynamic input fields -->
<script>
    $(document).ready(function () {
        let buttonAdd = $("#add-button");
        let buttonRemove = $("#remove-button");
        let className = ".dynamic-field";
        let count = 0;
        let field = "";
        let maxFields = 50;

        function totalFields() {
            return $(className).length;
        }

        function addNewField() {
            count = totalFields() + 1;
            field = $("#units-1").clone();
            field.attr("id", "units-" + count);
            field.children("label").text("Pallet# " + count);
            field.find("input").val("");
            $(className + ":last").after($(field));
        }

        function removeLastField() {
            if (totalFields() > 1) {
                $(className + ":last").remove();
            }
        }

        function enableButtonRemove() {
            if (totalFields() === 2) {
                buttonRemove.removeAttr("disabled");
                buttonRemove.addClass("shadow-sm");
            }
        }

        function disableButtonRemove() {
            if (totalFields() === 1) {
                buttonRemove.attr("disabled", "disabled");
                buttonRemove.removeClass("shadow-sm");
            }
        }

        function disableButtonAdd() {
            if (totalFields() === maxFields) {
                buttonAdd.attr("disabled", "disabled");
                buttonAdd.removeClass("shadow-sm");
            }
        }

        function enableButtonAdd() {
            if (totalFields() === (maxFields - 1)) {
                buttonAdd.removeAttr("disabled");
                buttonAdd.addClass("shadow-sm");
            }
        }

        buttonAdd.click(function () {
            addNewField();
            enableButtonRemove();
            disableButtonAdd();
        });

        buttonRemove.click(function () {
            removeLastField();
            disableButtonRemove();
            enableButtonAdd();
        });
    });

</script>

<!-- Add dynamic containers -->
<script>
    $(document).ready(function () {
        let buttonAdd = $("#add_container");
        let buttonRemove = $("#remove_container");
        let className = ".dynamic-container";
        let count = 0;
        let field = "";
        let maxFields = 50;

        function totalFields() {
            return $(className).length;
        }

        function addNewField() {
            count = totalFields() + 1;
            field = $("#container-1").clone();
            field.attr("id", "container-" + count);
            field.children("label").text("Container# " + count);
            field.find("input").val("");
            $(className + ":last").after($(field));
        }

        function removeLastField() {
            if (totalFields() > 1) {
                $(className + ":last").remove();
            }
        }

        function enableButtonRemove() {
            if (totalFields() === 2) {
                buttonRemove.removeAttr("disabled");
                buttonRemove.addClass("shadow-sm");
            }
        }

        function disableButtonRemove() {
            if (totalFields() === 1) {
                buttonRemove.attr("disabled", "disabled");
                buttonRemove.removeClass("shadow-sm");
            }
        }

        function disableButtonAdd() {
            if (totalFields() === maxFields) {
                buttonAdd.attr("disabled", "disabled");
                buttonAdd.removeClass("shadow-sm");
            }
        }

        function enableButtonAdd() {
            if (totalFields() === (maxFields - 1)) {
                buttonAdd.removeAttr("disabled");
                buttonAdd.addClass("shadow-sm");
            }
        }

        buttonAdd.click(function () {
            addNewField();
            enableButtonRemove();
            disableButtonAdd();
        });

        buttonRemove.click(function () {
            removeLastField();
            disableButtonRemove();
            enableButtonAdd();
        });
    });

</script>

@endsection
