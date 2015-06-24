var Login = function () {
    
    return {
        //main function to initiate the module
        init: function () {
        	
           $('.login-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                name: {
	                    required: true
	                },
	                password: {
	                    required: true
	                }
	            },

	            messages: {
	                name: {
	                    required: "请输入用户名."
	                },
	                password: {
	                    required: "请输入密码."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                //$('.alert-error', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
                    login();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
                        login();
	                }
	                return false;
	            }
	        });

            var login = function() {
                $('.alert-error', $('.login-form')).hide();
                var data = $("#loginForm").serialize();
                $.ajax({
                    url: baseURL + "main/log-in",
                    dataType: 'json',
                    type: "POST",
                    data: data,
                    success: function (d) {
                        if (d.status == 0) {
                            window.location.href=baseURL;
                        }
                        else {
                            $('.alert-error', $('.login-form')).show();
                        }
                    }
                });
            }
        }

    };

}();