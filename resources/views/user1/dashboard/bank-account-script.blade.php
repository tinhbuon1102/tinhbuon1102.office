<script>
    $(function(){
        var form = $("#bank-account");

        form.validationEngine('attach', {
            onValidationComplete: function(form, status){
                if (status == true) {

                    form.on('submit', function(e) {
                        e.preventDefault();
                    });

                    console.log("Successful! Now submitting");


                    // Send request
                    paymentInfo();
                } else {

                    form.on('submit', function(e) {
                        e.preventDefault();
                    });

                    console.log("Errors! Stopping Here");
                }
            },
            promptPosition : "topLeft",
            scroll: false
        });


        var getKeyCode = function (str) {
            return str.charCodeAt(str.length - 1);
        };

        $('#bank_code111', form).keyup(function(e){

            var code = $('#bank_code').val();
            if (code.length < 4) {
                $('.bank-branch-data-wrapper', form).addClass('hide');
                return;
            }


            var keyCode = e.keyCode || e.which;
            if (keyCode == 0 || keyCode == 229) { //for android chrome keycode fix
                keyCode = getKeyCode(this.value);
            }

            console.log(keyCode)
            if (!((48 <= keyCode && keyCode <= 57) || keyCode == 91 || keyCode == 17)) { // 0 - 9, cmd, ctrl
                return;
            }

            $('#bank_name').val('').attr('placeholder', '');

            if (code.length != 4) {
                $('.bank-branch-data-wrapper', form).addClass('hide');
                return;
            }

            getBankInfo(code, function (data) {
                console.log(data);
                $('.bank-branch-data-wrapper', form).removeClass('hide');
                $('#bank_code').validationEngine('hide');
                $('#bank_name').val(data.name);
            }, function () {
                $('.bank-branch-data-wrapper', form).addClass('hide');
                $('#bank_name').val('');
            });
        });

        $('#branch_code1111', form).keyup(function(e){

            var keyCode = e.keyCode || e.which;
            if (keyCode == 0 || keyCode == 229) { //for android chrome keycode fix
                keyCode = getKeyCode(this.value);
            }

            console.log(keyCode);
            if (!(48 <= keyCode && keyCode <= 57)) { // 0 - 9
                return;
            }

            $('#branch_name').val('').attr('placeholder', ''); // empty

            var code = $('#bank_code').val();
            var branch = $('#branch_code').val();

            if (code.length != 4) {
                return;
            }

            if (branch.length != 3) {
                return;
            }


            getBranchInfo(code, branch, function (data) {

                console.log(data);
                $('#branch_code').validationEngine('hide');
                $('#branch_name').val(data.name);
            }, function () {
                $('#branch_name').val('').attr('placeholder', ''); // empty
            });
        });
    });


    function paymentInfo() {
        var $form   = $('#bank-account'),
            params  = $form.serialize(),
            url     = $form.attr("action");

        console.log(params);

        $.ajax({
            type    : "POST",
            url     : url,
            data    : params,
            success: function(data){
                console.log(data);
                if(data.success) {
                    jQuery("#spanAccountType").text(jQuery('#account-type-radio input:radio:checked').val());
                    console.log(jQuery('#account-type-radio input:radio:checked').val());



                    jQuery("#spanAccountName").text(jQuery('input[name="AccountName"]').val());
                    jQuery("#spanAccountNumber").text(jQuery('input[name="AccountNumber"]').val());
                    jQuery("#spanBankCode").text(jQuery('input[name="BankCode"]').val());
                    jQuery("#spanBankName").text(jQuery('input[name="BankName"]').val());
                    jQuery("#spanBranchCode").text(jQuery('input[name="BranchCode"]').val());
                    jQuery("#spanBranchLocationName").text(jQuery('input[name="BranchLocationName"]').val());

                    jQuery(".bank-account-edit-container").toggle();
                    jQuery(".saved-bank-account").toggle();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    var errors = jqXHR.responseJSON;
                    $.each(errors, function(key, value) {
                        $('input[name="' + key + '"]', $form).validationEngine('showPrompt', value[0]);
                    });
                }
            }
        },"json");
    }

    function getBankInfo(bankCode, success, error) {
        $.ajax({
            type    : "GET",
            url     : "{{url('ShareUser/Dashboard/HostSetting/GetBankInfo')}}",
            data    : {
                'bank' : bankCode
            },
            success: function(data){
                console.log(data);

                if (data.success) {
                    if (typeof(success) == 'function') {
                        success(data.response);
                    }
                }
            },
            error : function (response) {
                if (typeof(error) == 'function') {
                    error();
                }

                if (response.status === 422) {
                    var errors = response.responseJSON,
                        bankError = (typeof(errors['bank']) != 'undefined') ?
                            errors['bank'][0] : false;
                    if (bankError) {
                        $('#bank_code').validationEngine('showPrompt', bankError);
                    }
                }

            }
        },"json");
    }

    function getBranchInfo(bankCode, branchCode, success) {
        $.ajax({
            type    : "GET",
            url     : "{{url('ShareUser/Dashboard/HostSetting/GetBranchInfo')}}",
            data    : {
                'bank' : bankCode,
                'branch' : branchCode
            },
            success: function(data){
                console.log(data);

                if (data.success) {
                    if (typeof(success) == 'function') {
                        success(data.response);
                    }
                }
            },
            error : function(response) {
                if (typeof(error) == 'function') {
                    error();
                }

                if (response.status === 422) {
                    var errors = response.responseJSON,
                        bankError = (typeof(errors['bank']) != 'undefined') ?
                            errors['bank'][0] : false,
                        branchError = (typeof(errors['branch']) != 'undefined') ?
                            errors['branch'][0] : false;

                    console.log(errors);

                    if (bankError) {
                        $('#bank_code').validationEngine('showPrompt', bankError);
                    }
                    if (branchError) {
                        $('#branch_code').validationEngine('showPrompt', branchError);
                    }
                }

            }
        },"json");
    }


</script>