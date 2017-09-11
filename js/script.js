$(document).ready(function ()
{
    $('#btnLogOut').click(function () {
        $.ajax({
            url: "unsetSession",
            type: "POST",
            data: {},
            dataType: "json",
            success: function (data)
            {
                window.location = "index";
            }
        });
    });

    tinymce.init({
        selector: '#textareatinymce',
        height: 200,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });

    $("#btnSaveMember").click(function () {
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();
        var address = $("#address").val();
        var mobileNumber = $("#mobileNumber").val();
        var emailAddress = $("#emailAddress").val();
        var userName = $("#userName").val();
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();

        $("#saveStatus").html("");
        if (firstName == "" || lastName == "" || address == "" || mobileNumber == "" || emailAddress == "" || userName == "" || password == "" || confirmPassword == "")
        {
            $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Please enter complete details. Try again.</strong>' +
                    '</div>');
        } else
        {
            if (password != confirmPassword)
            {
                $("#saveStatus").html('<div class="alert alert-danger">' +
                        '<strong>Password do not match. Try again.</strong>' +
                        '</div>');
            } else
            {
                $.ajax({
                    url: "saveNewMember",
                    type: "POST",
                    data: {
                        firstName: firstName,
                        lastName: lastName,
                        address: address,
                        mobileNumber: mobileNumber,
                        emailAddress: emailAddress,
                        userName: userName,
                        password: password,
                        confirmPassword: confirmPassword
                    },
                    dataType: "json",
                    success: function (data)
                    {
                        $("#saveStatus").html('<div class="alert alert-success">' +
                                '<strong>' + data + '</strong>' +
                                '</div>');
                    }
                });
            }
        }
    });

    $(document).on("click", "#btnEditMember", function () {
        var memberid = $(this).attr("data-id");
        $('#myModalEditMembers').modal('toggle');
        $.ajax({
            url: "getMembersDetails",
            type: "POST",
            data: {memberid: memberid},
            dataType: "json",
            success: function (data)
            {
                $("#editid").val(data[0]['id']);
                $("#editFirstName").val(data[0]['firstname']);
                $("#editLastName").val(data[0]['lastname']);
                $("#editAddress").val(data[0]['address']);
                $("#editMobileNumber").val(data[0]['mobile']);
                $("#editEmailAddress").val(data[0]['email']);
                $("#editUsername").val(data[0]['username']);
                $("#editPassword").val('');
            }
        });
    });

    $(document).on("click", "#btnRemoveMember", function () {
        var memberid = $(this).attr("data-id");
        var confirmRemove = confirm("Are you sure you want to remove this member?");
        if (confirmRemove)
        {
            $.ajax({
                url: "removeMember",
                type: "POST",
                data: {memberid: memberid},
                dataType: "json",
                success: function (data)
                {
                    $("#member" + memberid).fadeOut('slow');
                }
            });
        }
    });
    
    $(document).on("click", ".btnRemoveProductCategory", function () {
        var elem = $(this);
        var id = $(this).attr("data-id");
        var confirmRemove = confirm("Are you sure you want to remove this category?");
        if (confirmRemove)
        {
            $.ajax({
                url: "/admin/removeCategory",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (data)
                {
                    if(data.success)
                    {
                        $(elem).parents('tr').fadeOut('slow');
                    }
                    else
                    {
                        alert("Error removing from the database.");
                    }
                }
            });
        }
    });
    
    $(document).on("click", ".btnRemoveServiceCategory", function () {
        var elem = $(this);
        var id = $(this).attr("data-id");
        var confirmRemove = confirm("Are you sure you want to remove this category?");
        if (confirmRemove)
        {
            $.ajax({
                url: "/admin/removeServiceCategory",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (data)
                {
                    if(data.success)
                    {
                        $(elem).parents('tr').fadeOut('slow');
                    }
                    else
                    {
                        alert("Error removing from the database.");
                    }
                }
            });
        }
    });

    $("#btnUpdateMember").click(function () {
        var id = $("#editid").val();
        var newFirstName = $("#editFirstName").val();
        var newLastName = $("#editLastName").val();
        var newAddress = $("#editAddress").val();
        var newMobileNumber = $("#editMobileNumber").val();
        var newEmailAddress = $("#editEmailAddress").val();
        var newUsername = $("#editUsername").val();
        var newPassword = $("#editPassword").val();

        $("#editStatus").html("");
        if (newFirstName == "" || newLastName == "" || newAddress == "" || newMobileNumber == "" || newEmailAddress == "" || newUsername == "")
        {
            $("#editStatus").append('<div class="alert alert-warning">' +
                    '<strong>Please enter complete details. Try again.</strong>' +
                    '</div>');
        } else
        {
            $.ajax({
                url: "/admin/updateMember",
                type: "POST",
                data: {
                    id: id,
                    newFirstName: newFirstName,
                    newLastName: newLastName,
                    newAddress: newAddress,
                    newMobileNumber: newMobileNumber,
                    newEmailAddress: newEmailAddress,
                    newUsername: newUsername,
                    newPassword: newPassword
                },
                dataType: "json",
                success: function (data)
                {
                    $("#editStatus").append('<div class="alert alert-success">' +
                            '<strong>' + data + '</strong>' +
                            '</div>');
                    $("#memberFname" + id).html(newFirstName);
                    $("#memberLname" + id).html(newLastName);
                    $("#memberMobile" + id).html(newMobileNumber);
                }
            });
        }
    });

    $("#file").change(function () {
        var file = $("#file")[0].files[0];
        $("#filename").val(file.name);
    });

    $(document).on("click", "#btnRemoveProduct", function () {
        var productid = $(this).attr("data-id");
        var confirmRemove = confirm("Are you sure you want to remove this product?");
        if (confirmRemove)
        {
            $.ajax({
                url: "removeProduct",
                type: "POST",
                data: {productid: productid},
                dataType: "json",
                success: function (data)
                {
                    $("#product" + productid).fadeOut('slow');
                }
            });
        }
    });

    $(document).on("click", "#btnEditProduct", function () {
        var id = $(this).attr("data-id");
    });

    $('#btnSaveDoctor').click(function () {
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var mobileNumber = $('#mobileNumber').val();
        var sun = $('#sunday').is(":checked") ? '1' : '0';
        var mon = $('#monday').is(":checked") ? '1' : '0';
        var tues = $('#tuesday').is(":checked") ? '1' : '0';
        var wed = $('#wednesday').is(":checked") ? '1' : '0';
        var thurs = $('#thursday').is(":checked") ? '1' : '0';
        var fri = $('#friday').is(":checked") ? '1' : '0';
        var sat = $('#saturday').is(":checked") ? '1' : '0';
        var timeIn = $('#timeIn').val();
        var timeOut = $('#timeOut').val();

        $("#saveStatus").html("");
        if (firstName == "" || lastName == "" || mobileNumber == "" || timeIn == "" || timeOut == "")
        {
            $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Please enter needed details. Try again.</strong>' +
                    '</div>');
        } else
        {
            $.ajax({
                url: "addNewDoctorDetails",
                type: "POST",
                data: {
                    firstName: firstName,
                    lastName: lastName,
                    mobileNumber: mobileNumber,
                    sun: sun,
                    mon: mon,
                    tues: tues,
                    wed: wed,
                    thurs: thurs,
                    fri: fri,
                    sat: sat,
                    timeIn: timeIn,
                    timeOut: timeOut
                },
                dataType: "json",
                success: function (data)
                {
                    $("#saveStatus").html('<div class="alert alert-success">' +
                            '<strong>' + data + '</strong>' +
                            '</div>');
                    $('#firstName').val("");
                    $('#lastName').val("");
                    $('#mobileNumber').val("");
                    $('.dayOption').prop('checked', false);
                    $('#timeIn').val("");
                    $('#timeOut').val("");
                }
            });
        }
    });

    $('#btnSaveUser').click(function () {
        var userName = $('#userName').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();

        $("#saveStatus").html("");
        if (userName == "" || password == "" || confirmPassword == "")
        {
            $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Please enter complete details. Try again.</strong>' +
                    '</div>');
        } else
        {
            if (password == confirmPassword)
            {
                $.ajax({
                    url: "addNewUserAdmin",
                    type: "POST",
                    data: {
                        userName: userName,
                        password: password
                    },
                    dataType: "json",
                    success: function (data)
                    {
                        $("#saveStatus").html('<div class="alert alert-success">' +
                                '<strong>' + data + '</strong>' +
                                '</div>');
                        $('#userName').val("");
                        $('#password').val("");
                        $('#confirmPassword').val("");
                    }
                });
            } else
            {
                $("#saveStatus").html('<div class="alert alert-danger">' +
                        '<strong>Password do not match. Try again.</strong>' +
                        '</div>');
            }
        }
    });

    $(document).on("click", "#btnRemoveDoctor", function () {
        var doctorid = $(this).attr("data-id");
        var confirmRemove = confirm("Are you sure you want to remove a doctor?");
        if (confirmRemove)
        {
            $.ajax({
                url: "removeDoctor",
                type: "POST",
                data: {doctorid: doctorid},
                dataType: "json",
                success: function (data)
                {
                    $("#doctor" + doctorid).fadeOut('slow');
                }
            });
        }
    });

    $(document).on("click", "#btnEditDoctor", function () {
        $('#myModalEditDoctor').modal('toggle');
        var doctorid = $(this).attr("data-id");

        $.ajax({
            url: "getDoctorDetails",
            type: "POST",
            data: {doctorid: doctorid},
            dataType: "json",
            success: function (data)
            {
                $('.dayOption').prop('checked', false);

                $('#doctorId').val(data[0]['id']);
                $('#editFirstName').val(data[0]['firstname']);
                $('#editLastName').val(data[0]['lastname']);
                $('#editMobileNumber').val(data[0]['mobile']);

                var sun = data[0]['sun'] == 1 ? true : false;
                var mon = data[0]['mon'] == 1 ? true : false;
                var tues = data[0]['tue'] == 1 ? true : false;
                var wed = data[0]['wed'] == 1 ? true : false;
                var thurs = data[0]['thur'] == 1 ? true : false;
                var fri = data[0]['fri'] == 1 ? true : false;
                var sat = data[0]['sat'] == 1 ? true : false;

                $('#editsunday').prop('checked', sun);
                $('#editmonday').prop('checked', mon);
                $('#edittuesday').prop('checked', tues);
                $('#editwednesday').prop('checked', wed);
                $('#editthursday').prop('checked', thurs);
                $('#editfriday').prop('checked', fri);
                $('#editsaturday').prop('checked', sat);

                $('#editTimeIn').val(data[0]['time_in']);
                $('#editTimeOut').val(data[0]['time_out']);
            }
        });
    });

    $('#btnUpdateDoctor').click(function () {
        var doctorid = $('#doctorId').val();
        var editFirstName = $('#editFirstName').val();
        var editLastName = $('#editLastName').val();
        var editMobileNumber = $('#editMobileNumber').val();
        var sun = $('#editsunday').is(":checked") ? '1' : '0';
        var mon = $('#editmonday').is(":checked") ? '1' : '0';
        var tues = $('#edittuesday').is(":checked") ? '1' : '0';
        var wed = $('#editwednesday').is(":checked") ? '1' : '0';
        var thurs = $('#editthursday').is(":checked") ? '1' : '0';
        var fri = $('#editfriday').is(":checked") ? '1' : '0';
        var sat = $('#editsaturday').is(":checked") ? '1' : '0';
        var timeIn = $('#editTimeIn').val();
        var timeOut = $('#editTimeOut').val();

        $('#editStatus').html("");
        if (editFirstName == "" || editLastName == "" || editMobileNumber == "" || timeIn == "" || timeOut == "")
        {
            $("#editStatus").append('<div class="alert alert-warning">' +
                    '<strong>Please enter complete details. Try again.</strong>' +
                    '</div>');
        } else
        {
            $.ajax({
                url: "updateDoctor",
                type: "POST",
                data: {
                    doctorid: doctorid,
                    editFirstName: editFirstName,
                    editLastName: editLastName,
                    editMobileNumber: editMobileNumber,
                    sun: sun,
                    mon: mon,
                    tues: tues,
                    wed: wed,
                    thurs: thurs,
                    fri: fri,
                    sat: sat,
                    timeIn: timeIn,
                    timeOut: timeOut
                },
                dataType: "json",
                success: function (data)
                {
                    $("#editStatus").append('<div class="alert alert-success">' +
                            '<strong>' + data + '</strong>' +
                            '</div>');
                    $("#firstName" + doctorid).html(editFirstName);
                    $("#lastName" + doctorid).html(editLastName);
                    $("#mobileNumber" + doctorid).html(editMobileNumber);
                }
            });
        }
    });

    $('#btnCloseEditDoctor').click(function () {
        $('#editStatus').html("");
        $('.dayOption').prop('checked', false);
    });

    $('#optSpecie').change(function () {
        var specie_id = $(this).val();
        $.ajax({
            url: "/admin/getBreedBySpecieId",
            type: "POST",
            data: {
                specie_id: specie_id
            },
            dataType: "json",
            success: function (data)
            {
                $('#optBreed').html(" ");
                for (var i = 0; i < data.length; i++)
                {
                    $('#optBreed').append("<option value='"+data[i]['id']+"'>" + data[i]['name'] + "</option>");
                }
            }
        });
    });

    $('#btnAddNewPet').click(function () {
        var ownerName = $('#optOwnerName').val();
        var petName = $('#petName').val();
        var specie = $('#optSpecie').val();
        var breed = $('#optBreed').val();
        var petGender = $('#petGender').val() == "Male" ? '1' : '2';

        $('#saveStatus').html(" ");
        if (petName == "" || specie == null || breed == null)
        {
            $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Please enter complete details. Try again.</strong>' +
                    '</div>');
        } else
        {
            $.ajax({
                url: "saveNewPet",
                type: "POST",
                data: {
                    ownerName: ownerName,
                    petName: petName,
                    specie: specie,
                    breed: breed,
                    petGender: petGender
                },
                dataType: "json",
                success: function (data)
                {
                    $("#saveStatus").html('<div class="alert alert-success">' +
                            '<strong>' + data + '</strong>' +
                            '</div>');
                }
            });
        }
    });
    
    $('#btnAddSpecie').click(function () {
        var specie = $('#specieName').val();

        $('#saveStatus').html(" ");
        if (specie.trim() == "")
        {
            $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Please enter complete details. Try again.</strong>' +
                    '</div>');
        } else
        {
            $.ajax({
                url: "/admin/saveSpecie",
                type: "POST",
                data: {
                    specie: specie
                },
                dataType: "json",
                success: function (data)
                {
                    if(data.success)
                    {
                        $("#saveStatus").html('<div class="alert alert-success">' +
                                '<strong>Specie successfully added.</strong>' +
                                '</div>');
                        $('#specieName').val('');
                    }
                    else
                    {
                        $("#saveStatus").html('<div class="alert alert-warning">' +
                        '<strong>Error saving to the database. Try again.</strong>' +
                        '</div>');
                    }
                }
            });
        }
    });

    $(document).on("click", "#btnUpdatePet", function () {
        var data = {
            id : $("#editid").val(),
            name : $('#petName').val(),
            specie : $('#optSpecie').val(),
            breed : $('#optBreed').val(),
            gender : $('#petGender').val()
        };
        
        $.ajax({
            url: "/admin/updatePetData",
            type: "POST",
            data: data,
            dataType: "json",
            success: function (data)
            {
                if(data.success)
                {
                    alert("Pet successfully updated.");
                    window.location.reload();
                }
            }
        });
    });
    
    $(document).on("click", "#btnEditPet", function () {
        var petid = $(this).attr("data-id");
        var ownerid = $(this).attr("owner-id");
        $('#myModalEditPets').modal('toggle');

        $.ajax({
            url: "/admin/getPetData",
            type: "POST",
            data: {
                id: petid
            },
            dataType: "json",
            success: function (data)
            {
                $("#editid").val(petid);
                $('#petName').val($('#petname' + petid).html());
                $('#optSpecie').val(data.info.specie_id);
                var breed_id = data.info.breed_id;
                var speciename = $('#optSpecie').val();
                $.ajax({
                    url: "/admin/getBreedBySpecieId",
                    type: "POST",
                    data: {
                        specie_id: data.info.specie_id
                    },
                    dataType: "json",
                    success: function (data)
                    {
                        $('#optBreed').html(" ");
                        for (var i = 0; i < data.length; i++)
                        {
                            $('#optBreed').append("<option value='"+data[i]['id']+"'>" + data[i]['name'] + "</option>");
                        }
                        
                        $('#optBreed').val(breed_id);
                    }
                });
                
                $('#petGender').val(data.info.sex);
            }
        });
    });

    $(document).on("click", "#btnRemovePet", function () {
        var petid = $(this).attr("data-id");
        var confirmRemove = confirm("Are you sure you want to remove this pet?");

        if (confirmRemove)
        {
            $.ajax({
                url: "removePet",
                type: "POST",
                data: {petid: petid},
                dataType: "json",
                success: function (data)
                {
                    $('#pet' + petid).fadeOut('slow');
                }
            });
        }
    });

    $(document).on("click", "#btnViewMember", function () {
        var id = $(this).attr("data-id");
        $('#myModalViewMembers').modal('toggle');

        $.ajax({
            url: "getMembersDetailsForView",
            type: "POST",
            data: {id: id},
            dataType: "json",
            success: function (data)
            {
                $('#petsList').html(" ");
                console.log(data);
                var fullname = data['memberDetails'][0]['firstname'] + " " + data['memberDetails'][0]['lastname'];
                $('#fullName').html(fullname);
                $('#address').html(data['memberDetails'][0]['address']);
                $('#mobile').html(data['memberDetails'][0]['mobile']);
                $('#email').html(data['memberDetails'][0]['email']);

                for (var i = 0; i < data['petDetails'].length; i++)
                {
                    $('#petsList').append("<a href='pets/" + data['petDetails'][i]['id'] + "'>" + data['petDetails'][i]['name'] + "</a><br/>");
                }
            }
        });
    });

    $('#btnLogIn').click(function () {
        var username = $('#userName').val();
        var password = $('#password').val();

        $.ajax({
            url: "admin/logIn",
            type: "POST",
            data: {
                username: username,
                password: password
            },
            dataType: "json",
            success: function (data)
            {
                if (data.length == 0)
                {
                    $('#logInStatus').html('<br/><div class="alert alert-danger">' +
                            '<strong>Please check your username and password. Try again.</strong>' +
                            '</div>');
                } else
                {
                    window.location = "admin/products";
                }
            }
        });
    });

    $(document).on("click", "#btnRemoveService", function () {
        var id = $(this).attr("data-id");
        var confirmRemove = confirm("Are you sure you want to remove this service?");

        if (confirmRemove)
        {
            $.ajax({
                url: "removeService",
                type: "POST",
                data: {id: id},
                dataType: "json",
                success: function (data)
                {
                    $('#service' + id).fadeOut('slow');
                }
            });
        }
    });

    $(document).on("click", "#btnEditService", function () {
        var id = $(this).attr("data-id");
        console.log(id);
    });
    
    $("#orderStatus").change(function(){
        var prev_value = $(this).attr('data-value');
        var order_id = $(this).attr('data-order');
        var change = confirm("Are you sure you want to change this order's status?");
        if(change)
        {
            $.ajax({
                url : "/admin/changeOrderStatus",
                method : "POST",
                data : {
                    order_id : order_id,
                    status : $(this).val()
                },
                dataType : "json",
                success : function(data)
                {
                    if(data.success)
                    {
                        //successful
                    }
                    else
                    {
                        alert("Error connecting to server.");
                    }
                },
                error : function()
                {
                    alert("Error connecting to server.");
                }
            });
        }
        else
        {
            $(this).val(prev_value);
        }
    });
    
    $("#appStatus").change(function(){
        var prev_value = $(this).attr('data-value');
        var app_id = $(this).attr('data-app');
        var change = confirm("Are you sure you want to change this appointment's status?");
        if(change)
        {
            $.ajax({
                url : "/admin/changeAppointmentStatus",
                method : "POST",
                data : {
                    app_id : app_id,
                    status : $(this).val()
                },
                dataType : "json",
                success : function(data)
                {
                    if(data.success)
                    {
                        //successful
                    }
                    else
                    {
                        alert("Error connecting to server.");
                    }
                },
                error : function()
                {
                    alert("Error connecting to server.");
                }
            });
        }
        else
        {
            $(this).val(prev_value);
        }
    });
    
    $("#edituserform").submit(function(){
        var id = $("#edit_id").val();
        var username = $("#userName").val();
        var password = $("#password").val();
        var cpassword = $("#confirmPassword").val();
        if(password != cpassword)
        {
            alert("Passwords do not match");
        }
        else
        {
            var data = {
                id : id,
                username : username,
                password : password
            };
            
            $.ajax({
                url : "/admin/updateUser",
                method : "POST",
                data : data,
                dataType : "json",
                success : function(data)
                {
                    if(data.success)
                    {
                        alert("User successfully updated")
                    }
                    else
                    {
                        alert("Error connecting to server.");
                    }
                },
                error : function()
                {
                    alert("Error connecting to server.");
                }
            });
        }
        return false;
    });
    
    $(".edit_specie").click(function(){
        $("#edit_specie_id").val('');
        $("#edit_specie_name").val('');
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        $("#editSpecieModal").modal('show');
        $("#edit_specie_name").val(name);
        $("#edit_specie_id").val(id);
    });
    
    $(".delete_specie").click(function(){
        var id = $(this).attr('data-id');
        var is_delete = confirm("Are you sure you want to delete this specie?");
        if(is_delete)
        {
            $.ajax({
                url : "/admin/deleteSpecie",
                method : "POST",
                data : {
                    id : id
                },
                dataType : "json",
                success : function(data)
                {
                    if(data.success)
                    {
                        alert("Specie successfully deleted");
                        window.location.reload();
                    }
                    else
                    {
                        alert("Error connecting to server.");
                    }
                },
                error : function()
                {
                    alert("Error connecting to server.");
                }
            });
        }
    });
    
    $("#btnUpdateSpecie").click(function(){
       var data = {
         id : $("#edit_specie_id").val(),
         name : $("#edit_specie_name").val()
       };
       
       $.ajax({
            url : "/admin/updateSpecie",
            method : "POST",
            data : data,
            dataType : "json",
            success : function(data)
            {
                if(data.success)
                {
                    alert("Specie successfully updated");
                    window.location.reload();
                }
                else
                {
                    alert("Error connecting to server.");
                }
            },
            error : function()
            {
                alert("Error connecting to server.");
            }
        });
    });
    
    $("#specieSelector").change(function(){
       var id = $(this).val();
       window.location.href = '/admin/breeds/'+id;
    });
    
    $("#frmBreed").submit(function(){
        var name = $("#breedName").val();
        var specie = $("#specie").val();
        var data = {
            name : name,
            specie : specie
        };
        
        $.ajax({
            url : "/admin/saveBreed",
            method : "POST",
            data : data,
            dataType : "json",
            success : function(data)
            {
                if(data.success)
                {
                    $("#saveStatus").html('<div class="alert alert-success">' +
                                '<strong>Breed successfully added.</strong>' +
                                '</div>');
                    $("#breedName").val('');
                    $("#specie").val('');
                }
                else
                {
                    $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Error connecting to server.</strong>' +
                    '</div>');
                }
            },
            error : function()
            {
                $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Error connecting to server.</strong>' +
                    '</div>');
            }
        });
        
        return false; 
    });
    
    $("#frmEditBreed").submit(function(){
        var name = $("#breedName").val();
        var specie = $("#specie").val();
        var id = $("#edit_id").val();
        var data = {
            name : name,
            specie : specie,
            id : id
        };
        
        $.ajax({
            url : "/admin/updateBreed",
            method : "POST",
            data : data,
            dataType : "json",
            success : function(data)
            {
                if(data.success)
                {
                    $("#saveStatus").html('<div class="alert alert-success">' +
                                '<strong>Breed successfully updated.</strong>' +
                                '</div>');
                }
                else
                {
                    $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Error connecting to server.</strong>' +
                    '</div>');
                }
            },
            error : function()
            {
                $("#saveStatus").html('<div class="alert alert-warning">' +
                    '<strong>Error connecting to server.</strong>' +
                    '</div>');
            }
        });
        
        return false; 
    });
    
    $(".delete_breed").click(function(){
        var id = $(this).attr('data-id');
        var is_delete = confirm("Are you sure you want to delete this breed?");
        if(is_delete)
        {
            $.ajax({
                url : "/admin/deleteBreed",
                method : "POST",
                data : {
                    id : id
                },
                dataType : "json",
                success : function(data)
                {
                    if(data.success)
                    {
                        alert("Breed successfully deleted.");
                        window.location.reload();
                    }
                    else
                    {
                        alert("Error connecting to server.");
                    }
                },
                error : function()
                {
                    alert("Error connecting to server.");
                }
            });
        }
    });
    
    $("#orderStatusSelector").change(function(){
        var id = $(this).val();
        window.location.href = '/admin/orders/'+id;
    });
    
    $("#appointmentStatusSelector").change(function(){
        var id = $(this).val();
        window.location.href = '/admin/appointments/'+id;
    });
    
});
