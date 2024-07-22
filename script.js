var member_id_for_payment = 0;
var amount_for_payment = 0;
var date;
$(document).ready(function () {
    $("#crossIcon").hide();

    $('#nic').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });


    $('#nameIn,#aRlname,#aRfname').on('input', function () {
        var name = $(this).val();
        $(this).val(name.charAt(0).toUpperCase() + name.slice(1).toLowerCase());
        var valid = /^[a-zA-Z]+( [a-zA-Z]+)*$/.test(name);

        if (name.length > 50) {
            $(this).val(name.slice(0, -1));
        } else if (!valid && name.length > 0) {
            $(this).val(name.replace(/[^a-zA-Z ]/g, '').replace(/\s+/g, ' '));
        }
    });

    $('#rRpassword').on('input', function () {
        var password = $(this).val();
        var isValid = /^[a-zA-Z0-9!@#$%]+$/.test(password);
        if (password.length > 50 || !isValid) {
            $(this).val(password.slice(0, -1));
        }
    });

    $('#nic ,#aRnic').on('input', function () {
        var nic = $(this).val();
        var validFormat = /^(\d{0,9}|\d{9}[vV]|\d{0,12})$/.test(nic);

        if (!validFormat) {
            $(this).val(nic.slice(0, -1));
        }
    });

    $('#email , #aRemail').on('input', function () {
        var email = $(this).val();
        var lastChar = email.slice(-1);

        if (!/^[a-zA-Z@.]$/.test(lastChar) && lastChar) {
            $(this).val(email.slice(0, -1));
        }
    });

    $('#mobileNum ,#aRmobileN').on('input', function () {
        var number = $(this).val();
        var valid = /^(\d{0,10})$/.test(number);
        if (!valid) {
            $(this).val(number.slice(0, -1));
        }
    });
    $('#injuries').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z0-9.,() \\n]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key) && event.keyCode !== 8 && event.keyCode !== 13 && event.keyCode !== 37 && event.keyCode !== 39) { // Allow backspace, enter, and arrow keys
            event.preventDefault();
            return false;
        }

        if (key === "'" || key === "\"") {
            event.preventDefault();
            return false;
        }
    });

    $('#dob').on('input', function () {
        var input = $(this).val();
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var validDateOfBirth = /^(\d{0,4})-?(\d{0,2})-?(\d{0,2})$/;


        input = input.replace(/^(\d{4})(\d{2})$/, '$1-$2').replace(/^(\d{4}-\d{2})(\d+)$/, '$1-$2');


        if (!validDateOfBirth.test(input)) {

            $(this).val(input.slice(0, -1));
            return;
        }

        var parts = input.split('-');
        if (parts.length === 3) {
            var year = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10);
            var day = parseInt(parts[2], 10);

            if (year > currentYear) {
                $(this).val(`${currentYear}-${parts[1]}-${parts[2]}`);
                return;
            }

            if (month > 12) {
                $(this).val(`${parts[0]}-12-${parts[2]}`);
                return;
            }

            var daysInMonth = new Date(year, month, 0).getDate();
            if (day > daysInMonth) {
                $(this).val(`${parts[0]}-${parts[1]}-${daysInMonth}`);
                return;
            }
        }

        $(this).val(input);
    });

    $('#address').on('input', function () {
        var allowedChars = /^[a-zA-Z0-9,\./\s]*$/;
        var currentValue = $(this).val();

        if (!allowedChars.test(currentValue)) {
            $(this).val(currentValue.slice(0, -1));
        }
    });
    $('#mesurmentTableP tr td').on('input', function () {
        const currentValue = $(this).text();
        const numeric = $.isNumeric(currentValue);

        if (!numeric) {
            $(this).text(currentValue.slice(0, -1));
        } else {
        }
    });

    $('#occupationInput ,#pCAOR ,#pGoal').on('input', function () {
        var allowedChars = /^[a-zA-Z() ]*$/;
        var currentValue = $(this).val();

        if (!allowedChars.test(currentValue)) {
            $(this).val(currentValue.slice(0, -1));
        }
    });

    $('#registerBtn').on('click', function (event) {
        event.preventDefault();
        var name = $('#nameIn').val();
        var nic = $('#nic').val();
        var email = $('#email').val();
        var mobileNum = $('#mobileNum').val();
        var dob = $('#dob').val();
        var address = $('#address').val();
        var occupationInput = $('#occupationInput').val();
        var mShipSelection = $('#mShipSelection').val();

        var gender = $('input[name="flexRadioDefault"]:checked').val();
        var coachingAdvice = $('input[name="flexRadioDefault1"]:checked').val();
        var termsAndConditions = $('#agreeTrems').is(':checked');

        var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var namevalid = /^[a-zA-Z]+( [a-zA-Z]+)*$/.test(name);
        var mNvalid = /^07\d{8}$/.test(mobileNum);
        var addressValid = /^[a-zA-Z0-9',.() ]+$/;
        // var injuryvalid = /^[a-zA-Z0-9., ()\\n]+$/;
        var occupationvalid = /^[a-zA-Z ()]*$/;

        if (!name || !mobileNum || !dob || !mShipSelection || !address || !occupationInput || !gender || !coachingAdvice) {
            alert("Please fill all the fields and agree to the terms and conditions.");
            return;
        } else if (!namevalid) {
            alert("Invaild Name");
        } else if (!mNvalid) {
            alert("Invaild Mobile Number");
        } else if (!addressValid.test(address)) {
            alert("Invalid Adress.");
        } else if (!occupationvalid.test(occupationInput)) {
            alert("Invalid occupation");
        } else if (!emailReg.test(email) && email != '') {
            alert("Invaild email address..!");
        } else if (!/^\d{12}$/.test(nic) && nic != '') {
            alert('NIC number must have either 9 or 12 digits.');
        } else {
            var dobPattern = /^\d{4}-\d{2}-\d{2}$/;

            if (dobPattern.test(dob)) {
                var dobDate = new Date(dob);
                var currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0);

                if (dobDate >= currentDate) {
                    alert('Invalid date of birth. The date must be before today.');
                    this.value = '';
                }
            } else {
                alert('Invalid date format. Please use the international format YYYY-MM-DD.');
                this.value = '';
            }
            if ($('#agreeTrems').is(':checked')) {
                $.ajax({
                    type: 'POST',
                    url: 'addNewMemberProcess.php',
                    data: {
                        name: name,
                        nic: nic,
                        email: email,
                        mobileNum: mobileNum,
                        dob: dob,
                        address: address,
                        mShipSelection: mShipSelection,
                        occupationInput: occupationInput,
                        gender: gender,
                        coachingAdvice: coachingAdvice,
                        termsAndConditions: termsAndConditions
                    },
                    success: function (response) {
                        if (response == "success") {
                            alert("Congratulations..Member Registration Successfully Completed.");
                            window.location.reload();
                        } else {
                            alert(response);
                        }
                    },
                    error: function (error) {
                        alert(error);
                    }
                });
            } else {
                alert("Please read and agree to trems and conditions.");
            }
        }
    });

    $("#memberSearch").on('input', function () {
        if ($(this).val().trim() !== '') {
            $("#searchClose").show();
            var value = $("#memberSearch").val().toLowerCase();
            if (value.length >= 1) {
                var mNUm = $("#mNum").val();
                for (let i = 0; i < mNUm; i++) {
                    var mId = $("#mId" + i).text();
                    var mName = $("#mName" + i).text().toLowerCase();

                    // Check if 'Han' is in 'Hansara'
                    if (mName.indexOf(value) !== -1 || mId.indexOf(value) !== -1) {
                        $('#mC' + i).show();
                    } else {
                        $('#mC' + i).hide();
                    }

                }
            } else if (value.length < 1) {
                var mNUm = $("#mNum").val();
                for (let i = 0; i < mNUm; i++) {
                    $('#mC' + i).show();
                }
            }

        } else {
            $("#searchClose").hide();
        }

    });

    $("#searchClose").on('click', function () {
        $("#memberSearch").val('');
        $(this).hide();
    });

    $("#addMemberClick").on('click', function () {
        $('#manageMem').removeClass('d-block');
        $('#manageMem').addClass('d-none');
        $('#addMem').removeClass('d-none');
        $('#addMem').addClass('d-block');
    });

    $("#manageMemClick").on('click', function () {
        $('#addMem').removeClass('d-block');
        $('#addMem').addClass('d-none');
        $('#manageMem').removeClass('d-none');
        $('#manageMem').addClass('d-block');
    });

    $("#tableBtn").on('click', function () {
        $('#prifleImgDiv').addClass('d-none');
        $('#cardImgTog').removeClass('col-lg-8 col-xlg-9 col-md-12');
        $('#cardImgTog').addClass('col-12');
    });

    $("#formBtn").on('click', function () {
        $('#prifleImgDiv').removeClass('d-none');
        $('#cardImgTog').removeClass('col-12');
        $('#cardImgTog').addClass('col-lg-8 col-xlg-9 col-md-12');
    });

    $("table.table tr td").on("click", function (e) {
        e.preventDefault();
    });


    $("#addtMeasurementBtn ").on('click', function () {
        $("#addNewMemTr").toggleClass("d-none");
        $("#cancelMeasurementBtn").toggleClass("d-none");
        $("#addtMeasurementBtn").toggleClass("d-none");
    });

    $("#cancelMeasurementBtn").on('click', function () {
        $("#addNewMemTr").toggleClass("d-none");
        $("#cancelMeasurementBtn").toggleClass("d-none");
        $("#addtMeasurementBtn").toggleClass("d-none");
    });

    $("#addNewS").on('click', function () {
        $("#cuS").toggleClass("d-none");
        $("#aNSchedule").toggleClass("d-none");
        $("#profileBtn").toggleClass("d-none");

        $("#addScheduleTable").show();
    });
    $("#aNSGoBack").on('click', function () {
        $("#cuS").toggleClass("d-none");
        $("#aNSchedule").toggleClass("d-none");
        $("#profileBtn").toggleClass("d-none");
        $("#sTableData").show();
    });

    $("#scheduleName").on('input', function () {
        var allowedChars = /^[a-zA-Z0-9: ]*$/;
        var input1 = $('#scheduleName').val();
        var input2 = input1.length;

        if (!allowedChars.test(input1) || input2 > 15) {
            $(this).val(input1.slice(0, -1));
        }
    });



    $('table td[contenteditable="true"]').on('keypress', function (event) {
        var maxLength = 45;
        var text = $(this).text();

        if (text.length >= maxLength) {
            $(this).css('border', '2px solid red');
            event.preventDefault();
            return false;
        } else {
            $(this).css('border', '');
            return true;
        }
    });

    $("#aSCBtn").on('click', function () {

        var workouts = [];
        var details = [];

        $('tbody#addScheduleTbody tr').each(function () {
            var workoutText = $(this).find('td:eq(0)').text();

            if (workoutText !== "") {
                workouts.push(workoutText);

                var detailsText = $(this).find('td:eq(1)').text();
                details.push(detailsText);
            }

        });

        var jWorkout = JSON.stringify(workouts);
        var jDetails = JSON.stringify(details);
        var id = $("#getMId1").val();
        var scheduleName = $("#scheduleName").val();
        var renewalDate = $("#renewalDate").text();

        $.ajax({
            type: 'POST',
            url: 'addScheduleProcess.php',
            data: {
                workouts: jWorkout,
                id: id,
                sN: scheduleName,
                rD: renewalDate,
                details: jDetails
            },
            success: function (response) {
                if (/^[0-9]*$/.test(response)) {
                    window.location = "schedule.php?id=" + response;
                } else {
                    console.log(response);
                }

            }

        });
    });

    // Prevent typing unnecessary words or symbols
    $('table td[contenteditable="true"] ').on('keypress', function (event) {
        var regex = /^[a-zA-Z0-9\s.,() -]+$/;
        var key = String.fromCharCode(event.which);

        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $('#profileBgImgDiv').on('click', function () {
        $('#updateProfileImg').click();
    });

    $("#updateProfileImg").on('change', function () {
        var file_count = this.files.length;
        if (file_count == 1) {
            var file = this.files[0];
            var url = URL.createObjectURL(file);
            $("#profileImg").attr("src", url);

        }
        else {
            alert("Only one profile image can select be selected.");
        }
    });

    $('#updateProfileBtn').on('click', function (event) {
        event.preventDefault();

        var name = $('#nameIn').val();
        var nic = $('#nic').val();
        var email = $('#email').val();
        var mobileNum = $('#mobileNum').val();
        var dob = $('#dob').val();
        var address = $('#address').val();
        var occupationInput = $('#occupationInput').val();
        var mShipSelection = $('#mShipSelection').val();
        var pGoal = $('#pGoal').val();
        var pCAOR = $('#pCAOR').val();
        var mId = $('#getMId').text();
        var pImg = document.getElementById("updateProfileImg").files;

        if (pImg.length > 1) {
            alert("Please select only one image.");
        }


        var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var namevalid = /^[a-zA-Z]+( [a-zA-Z]+)*$/.test(name);
        var mNvalid = /^07\d{8}$/.test(mobileNum);
        var addressValid = /^[a-zA-Z0-9',.() ]+$/;
        var occupationvalid = /^[a-zA-Z ()]*$/;

        const cellTexts = $("#mesurmentTableP tr td").text();
        const cellTextValidate = /^[0-9 .]*$/.test(cellTexts);


        if (!namevalid) {
            alert("Invaild Name");
        } else if (!mNvalid) {
            alert("Invaild Mobile Number");
        } else if (!addressValid.test(address)) {
            alert("Invalid Adress.");
        } else if (!occupationvalid.test(occupationInput)) {
            alert("Invalid occupation");
        } else if (!emailReg.test(email) && email != '') {
            alert("Invaild email address..!");
        } else if (!/^\d{12}$/.test(nic) && nic != '') {
            alert('NIC number must have either 9 or 12 digits.');
        } else if (!cellTextValidate && cellTexts != '') {
            alert('Measurement Contains unexpexted data.');
        } else {

            var measurements = [];

            $('#mesurmentTableP tr#addNewMemTr td').each(function () {
                const cellText = $(this).text();
                measurements.push(cellText);
            });

            var jMeasurments = JSON.stringify(measurements);

            var f = new FormData();
            f.append("pImg", $("#updateProfileImg")[0].files[0]);
            f.append("mId", mId);
            f.append("name", name);
            f.append("nic", nic);
            f.append("email", email);
            f.append("mobileNum", mobileNum);
            f.append("dob", dob);
            f.append("address", address);
            f.append("mShipSelection", mShipSelection);
            f.append("occupationInput", occupationInput);
            f.append("jMeasurments", jMeasurments);
            f.append("pGoal", pGoal);
            f.append("pCAOR", pCAOR);

            var request = new XMLHttpRequest();

            request.onreadystatechange = function () {
                if (request.status == 200 & request.readyState == 4) {
                    var response = request.responseText;
                    if (response == "Success") {
                        alert("Data Successfully Updated.");
                        window.location.reload();
                    } else {
                        console.log(response);
                    }
                }
            }

            request.open("POST", "updateProfileProcess.php", true);
            request.send(f);

        }
    });

    $('#payComfirmPassW[type="text"], #paymentIdCheck[type="text"]').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#paymentIdCheckBtn').on('click', function () {
        var id = $('#paymentIdCheck').val();
        if (!id) {
            window.location = 'memberPayment.php';
        } else {
            $('#btnCheckLoading').toggleClass("d-none");
            $.ajax({
                type: 'POST',
                url: 'memberPaymentProcess.php',
                data: {
                    id: id,
                },
                success: function (r) {
                    if (r == "error") {
                        $('#btnCheckLoading').toggleClass("d-none");
                        alert("There is no recode with this id...!");
                        window.location.reload();
                    } else {

                        const jsonArray = JSON.parse(r);
                        member_id_for_payment = jsonArray['id'];
                        amount_for_payment = jsonArray['p'];
                        date = jsonArray['nPaymentD'];

                        $('#confirmPaymentBtn').removeClass("d-none");
                        $('#payMemberDetails').removeClass("d-none");
                        $('#btnCheckLoading').toggleClass("d-none");

                        $('#payMemId').text(": " + jsonArray['id']);
                        $('#payMemName').text(": " + jsonArray['mem_name']);
                        $('#payMembership').text(": " + jsonArray['mshipName'] + " : Rs." + jsonArray['mshipPrice'] + ".00");
                        $('#payMemNPD').text(": " + jsonArray['nPaymentD']);
                        $('#payMemPayAmout').text(": Rs." + jsonArray['p'] + ".00");

                    }
                }, error: function (e) {
                    alert(r);

                }

            });
        }

    });

    $('#checkpaymentHistoryBtn').on('click', function () {
        if (member_id_for_payment == 0) {
            alert("Error.");
        } else {
            window.location = 'memberPayment.php?id=' + member_id_for_payment;
        }

    });

    $('#paymentConBtn').on('click', function () {
        var payComfirmPin = $('#payComfirmPassW').val();

        if (member_id_for_payment == 0) {
            alert("Error.");
        } else {
            $.ajax({
                type: 'POST',
                url: 'memberPaymentProcess1.php',
                data: {
                    pin: payComfirmPin,
                    id: member_id_for_payment,
                    DAT: date,
                    amount: amount_for_payment
                },
                success: function (r) {
                    if (r == "success") {
                        alert("Payment Successfull.");
                        window.location.reload();
                    } else {
                        alert(r);
                    }

                }, error: function () {
                    alert(r);
                }

            });

        }

    });

    $('#aURSignInBtn').on('click', function () {
        var fname = $('#aRfname').val();
        var lname = $('#aRlname').val();
        var email = $('#aRemail').val();
        var mobileNum = $('#aRmobileN').val();
        var nic = $('#aRnic').val();
        var ps = $('#rRpassword').val();
        var gender = $('#gender').val();
        var ATaC = $('#aRrememberMe').is(':checked');

        $.ajax({
            type: 'POST',
            url: 'signUpProcess.php',
            data: {
                fname: fname,
                lname: lname,
                email: email,
                mobileNum: mobileNum,
                nic: nic,
                ps: ps,
                gender: gender,
                ATaC: ATaC
            },
            success: function (r) {
                if (r == "success") {
                    $("#msg1").val("");
                    $("#msgdiv1").removeClass("d-none");
                    $("#msg1").addClass("alert-success");
                    $("#msg1").removeClass("alert-danger");
                    $("#msg1").text("Login successfull...!");
                    window.location = "login.php";

                } else {
                    $("#msg1").val("");
                    $("#msgdiv1").removeClass("d-none");
                    $("#msg1").addClass("alert-danger");
                    $("#msg1").removeClass("alert-success");
                    $("#msg1").text(r);
                }

            }, error: function () {
                console.log(r);
            }

        });
    });

    $('#aRlogInBtn').on('click', function () {

        var email = $('#aLemailNIC').val();
        var ps = $('#aLps').val();
        var ATaC = $('#rememberMe').is(':checked');

        $.ajax({
            type: 'POST',
            url: 'signInProcess.php',
            data: {
                email: email,
                ps: ps,
                ATaC: ATaC
            },
            success: function (r) {
                if (r == "success") {
                    $("#msg1").val("");
                    $("#msgdiv1").removeClass("d-none");
                    $("#msg1").addClass("alert-success");
                    $("#msg1").removeClass("alert-danger");
                    $("#msg1").text("Login successfull...!");
                    window.location = "index.php";

                } else {
                    $("#msg1").val("");
                    $("#msgdiv1").removeClass("d-none");
                    $("#msg1").addClass("alert-danger");
                    $("#msg1").removeClass("alert-success");
                    $("#msg1").text(r);
                }

            }, error: function () {
                console.log(r);
            }

        });
    });

    $('#eCost').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    descArray = [];
    costArray = [];
    typeArray = [];
    var count = 1

    $("#currentDetailsAdd").on('click', function () {
        var eDesc = $('#eDesc').val();
        var eCost = $('#eCost').val();
        var type = $('#tType').val();

        if (eDesc === "" || eCost === "") {
            alert("Please enter expense details and cost..!");
        } else if (!/^[a-zA-Z0-9 ().]*$/.test(eDesc) || !/^[0-9]*$/.test(eCost) || !type == '1' || !type == '2') {
            alert("Please enter valid Details. Details Contains unnecessary data.");
        } else {
            $('#currentExpenseDetails').removeClass('d-none');
            $('#currentExpenseDetails').append("<h5>" + count + ". " + eDesc + " : Rs. " + eCost + ".00</h5>");
            count++;
            descArray.push(eDesc);
            costArray.push(eCost);
            typeArray.push(type);

            $('#eDesc').val("");
            $('#eCost').val("");
            $('#tType').val(1);
        }
    })

    $('#transUpdateBtn').on('click', function () {
        var arrayLen = typeArray.length;

        var f = new FormData;
        if (!arrayLen == 0 && arrayLen == descArray.length) {
            var jdescArray = JSON.stringify(descArray);
            var jcostArray = JSON.stringify(costArray);
            var jtypeArray = JSON.stringify(typeArray);

            f.append("len", arrayLen);
            f.append("jdesc", jdescArray);
            f.append("jcost", jcostArray);
            f.append("jtype", jtypeArray);

            var r = new XMLHttpRequest();

            r.onreadystatechange = function () {
                if (r.readyState == 4 && r.status == 200) {
                    var t = r.responseText;
                    if (t == "success") {
                        window.location.reload();
                    } else {
                        alert(t);
                    }
                }
            }

            r.open("POST", "expensesProcess.php", true);
            r.send(f);
        } else {
            alert("Please enter expense details and cost before Update..!");

        }
    });

    $('#rAdvance').on('click', function () {
        var amount = $('#wAdvanceAmount').val();
        var nic = $('#wnic').val();
        var sal = $('#wSalary').val();

        $('#adRSpinner').removeClass("d-none");
        $('#wAdvanceAmount').addClass("d-none");
        var f = new FormData;

        f.append("amo", amount);
        f.append("nic", nic);
        f.append("sal", sal);

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "success") {
                    $('#adRSpinner').addClass("d-none");
                    alert("Request Sent Successfully.");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        }

        r.open("POST", "advanceProcess.php", true);
        r.send(f);
    });

    $('#wUpdateProfileBtn').on('click', function () {
        var email = $('#wEmail').val();
        var address = $('#wAddress').val();
        var mNumber = $('#wMobileNum').val();
        var sal = $('#wSalary').val();
        var id = $('#getWid').text();

        var f = new FormData;

        f.append("email", email);
        f.append("address", address);
        f.append("mNUm", mNumber);
        f.append("sal", sal);
        f.append("id", id);

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "success") {
                    alert("Request Sent Successfully.");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        }

        r.open("POST", "updateWorkerProfileProcess.php", true);
        r.send(f);
    });

    $('#disableUserBtn').on('click', function () {
        var id = $('#getMId').text();
        var f = new FormData;

        f.append("id", id);

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "Member Enabled." || t == "Member Disabled.") {
                    alert(t);
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        }

        r.open("POST", "disableMemberProcess.php", true);
        r.send(f);
    });
    $('#disableWorker').on('click', function () {
        var id = $('#getWid').text();
        var f = new FormData;

        f.append("id", id);

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "Member Enabled." || t == "Member Disabled.") {
                    alert(t);
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        }

        r.open("POST", "disableWorkerProcess.php", true);
        r.send(f);
    });

    // $('#dropUserBtn').on('click', function () {
    //     var id = $('#getMId').text();
    //     var f = new FormData;

    //     f.append("id", id);

    //     var r = new XMLHttpRequest();

    //     r.onreadystatechange = function () {
    //         if (r.readyState == 4 && r.status == 200) {
    //             var t = r.responseText;
    //             if (t == "success") {
    //                 alert("Request Sent Successfully.");
    //                 window.location="index.php";
    //             } else {
    //                 alert(t);
    //             }
    //         }
    //     }

    //     r.open("POST", "dropMemberProcess.php", true);
    //     r.send(f);
    // });

});

function goProfile(id) {
    window.location = "profile.php?id=" + id;
}
function goWProfile(id) {
    window.location = "workerProfile.php?id=" + id;
}

function memberse() {
    $("#addMem").hide();
    $("#manageMem").show();
}

function showSchedule(id) {
    $('#pS' + id).toggleClass("d-none");

}

function goToSchedule(id) {
    window.location = "schedule.php?id=" + id;
}
function backToProfile(id) {
    window.location = "profile.php?id=" + id;
}

function printDiv(divId) {
    const printContents = document.getElementById(divId).innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function showPassword() {
    var textField = document.getElementById("rRpassword");
    var ngnfd = document.getElementById("ngnfd");

    if (textField.type == "password") {
        textField.type = "text";
        ngnfd.classList = "bi bi-eye-slash";

    } else {
        textField.type = "password";
        ngnfd.classList = "bi bi-eye";
    }
}

function showPassword1() {
    var textField = document.getElementById("aLps");
    var ngnfd = document.getElementById("ngnfd1");

    if (textField.type == "password") {
        textField.type = "text";
        ngnfd.classList = "bi bi-eye-slash";

    } else {
        textField.type = "password";
        ngnfd.classList = "bi bi-eye";
    }
}

function expensesH3() {
    window.location = 'expenses.php';
}

function reportsH3() {
    window.location = 'reports.php';
}

function workList() {
    window.location = 'workerList.php';
}

function showTDT(TDT) {
    $('#' + TDT).toggleClass("d-none");
}

function logout() {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            window.location.reload();
        }
    }
    r.open("POST", "logout.php", true);
    r.send();
}

function forgetPassowrd() {

    document.getElementById("FPMSdiv").className = "d-none";
    document.getElementById("loadingDiv").classList = "d-flex justify-content-center mt-5 mb-5 fs-5";


    var FPemail = document.getElementById("FPemail");

    var f = new FormData();

    f.append("email", FPemail.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                document.getElementById("msg2").innerHTML = "Registration Successfull";
                document.getElementById("msg2").className = "alert alert-success";
                document.getElementById("msgdiv2").className = "d-block";
            } else if (t == "success01") {
                document.getElementById("FPCPdiv").className = "d-block";
                document.getElementById("loadingDiv").classList = "d-none";
            } else {
                document.getElementById("FPMSdiv").className = "d-block";
                document.getElementById("loadingDiv").classList = "d-none";
                document.getElementById("msg2").innerHTML = t;
                document.getElementById("msgdiv2").className = "d-block";
            }

        }
    }

    r.open("POST", "forgetPaswordProcess.php", true);
    r.send(f);

}

function verifyCode() {

    var btnVerify = document.getElementById("btnVerify");
    var code = document.getElementById("verifyCode").value;

    var f = new FormData();

    f.append("c", code);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {

                document.getElementById("newPassword").disabled = false;
                document.getElementById("ReNewPassword").disabled = false;
                document.getElementById("verifyCode").disabled = true;
                btnVerify.disabled = true;
                btnVerify.innerText = "Verified";
                btnVerify.classList.add("btn-success");

                document.getElementById("msgdiv3").className = "d-block";
                document.getElementById("msg3").classList.add("d-none");
                document.getElementById("msg4").classList.remove("d-none");

            } else {
                document.getElementById("msg3").innerHTML = t;
                document.getElementById("msgdiv3").className = "d-block";
            }
        }
    }

    r.open("POST", "resetPasswordProcess.php", true);
    r.send(f);
}


function changePassword() {

    var code = document.getElementById("verifyCode").value;
    var ReNewPassword = document.getElementById("ReNewPassword").value;
    var newPassword = document.getElementById("newPassword").value;

    var f = new FormData();

    f.append("c", code);
    f.append("nP", newPassword);
    f.append("rNP", ReNewPassword);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "index.php";

            } else {
                document.getElementById("msg4").classList.add("d-none");
                document.getElementById("msg3").innerHTML = t;
                document.getElementById("msg3").className = "alert alert-danger rounded-0 ";
                document.getElementById("msgdiv3").className = "d-block";
            }
        }
    }

    r.open("POST", "resetPasswordProcess1.php", true);
    r.send(f);
}

function cancel() {
    window.location = "forgetPassword.php";
}

function showPassword1() {
    var textField = document.getElementById("newPassword");
    var ngnfd = document.getElementById("ngnfd1");

    if (textField.type == "password") {
        textField.type = "text";
        ngnfd.classList = "bi bi-eye-slash";

    } else {
        textField.type = "password";
        ngnfd.classList = "bi bi-eye";
    }
}

function backTologin() {
    window.location = "index.php";
}

function deleteSchedule(s_id) {

    var f = new FormData;

    f.append("sid", s_id);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                alert("Schedule Deleted Successfully..!");
                window.location.reload();
            }
        }
    }

    r.open("POST", "deleteSchedule.php", true);
    r.send(f);
}