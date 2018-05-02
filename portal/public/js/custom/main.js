/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
/******/ })
/************************************************************************/
/******/ ({

/***/ 12:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(13);


/***/ }),

/***/ 13:
/***/ (function(module, exports) {

$(function () {
    //detect and show message to use other browser 
    var IE = detectIE();

    if (IE) {
        $("#browser-warning").parent().show();
    }

    //user creation form- role change based on role selection functionality  
    $("select#role").selectmenu({
        change: function change(event, data) {
            // hide previously shown in target div
            $("div", "div#extra-fields").hide();

            // read id from your select
            var value = data.item.value;
            // show element with selected id
            $("div#" + value).show();
            $("div#" + value + " input[name=role_id]").prop("disabled", false);
        }
    });

    //Hide all alert after 10 seconds
    var infoWindow = $("p.alert-info").parent();
    setTimeout(function () {
        infoWindow.hide(1000);
    }, 10000);

    //supplier role to have id of the supplier functionality autocomplete
    var token = $("#token").val();
    $("#supplier_autocomplete").autocomplete({
        source: function source(request, response) {
            $.ajax({
                url: "/portal/supplier/search/" + request.term + "?token=" + token,
                statusCode: {
                    401: function _() {
                        window.location.replace("/portal/login");
                    }
                },
                success: function success(data) {
                    response($.map(data.data, function (item) {
                        var AC = new Object();

                        //autocomplete default values REQUIRED
                        AC.label = item.name;
                        AC.value = item.id;

                        return AC;
                    }));
                },
                error: function error(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Something has gone wrong. Please refresh.");
                }
            });
        },
        minLength: 3,
        select: function select(event, ui) {
            $("#extra-fields input[name=role_id]").val(ui.item.id);
        }
    });

    //user creation form- role change based on role selection functionality
    $("div", "div#extra-fields").hide();
    $("#extra-fields input[name=role_id]").prop("disabled", true);

    $("select#role").change(function () {
        // hide previously shown in target div
        $("div", "div#extra-fields").hide();

        // read id from your select
        var value = $(this).val();
        // show element with selected id
        $("div#" + value).show();
        $("div#" + value + " input[name=role_id]").prop("disabled", false);
    });

    //on load check and disable/enable selection
    // $("input.pack,input.loose,input.sticky").each(function(){
    //     var elclass = $(this).data("item");
    //     var elements = $("input."+elclass);
    //     changeInputState(elements,this.checked);
    // });

    //selection of carton labels and sticky labels to generate labels
    $("#carton,#unit").on("change", "input[type='checkbox']", function () {
        var elclass = $(this).data("item");
        var elements = $("input." + elclass);
        changeInputState(elements, this.checked);
    });

    //selection of carton labels and sticky labels to generate labels
    $("table").on("click", "a.selectall", function (e) {
        e.preventDefault();
        var elclass = $(this).parent().data("type");
        var elements = $("input." + elclass);
        changeSelectCheckboxState(elements, true);
    });

    //selection of carton labels and sticky labels to generate labels
    $("table").on("click", "a.selectnone", function (e) {
        e.preventDefault();
        var elclass = $(this).parent().data("type");
        var elements = $("input." + elclass);
        changeSelectCheckboxState(elements, false);
    });

    //fancybox like pop up for account password recovery
    $(".venbobox").venobox({
        framewidth: "500px",
        frameheight: "auto",
        border: "10px",
        titleattr: "Password Recovery"
    });

    $("a.img-gallery").venobox({
        titleattr: 'data-title'
    });

    //Datatables to have pagination
    $("#users-list, #suppliers-list").DataTable({
        "sPaginationType": "full_numbers",
        "bPaginate": true,
        "iDisplayLength": 10,
        "searching": true,
        "ordering": false
    });

    $("#cartonfiles").DataTable({
        "sPaginationType": "full_numbers",
        "bPaginate": true,
        "iDisplayLength": 10,
        "searching": false,
        "ordering": false
    });

    $("#stickyfiles").DataTable({
        "sPaginationType": "full_numbers",
        "bPaginate": true,
        "iDisplayLength": 10,
        "searching": false,
        "ordering": false
    });
});

function changeInputState(inputs, state) {
    inputs.each(function () {
        $(this).prop("disabled", !state);
    });
}

function changeSelectCheckboxState(checkboxs, state) {
    checkboxs.each(function () {
        $(this).prop("checked", state);
        $(this).trigger("change");
    });
}

/**
 * detect IE
 * returns version of IE or false, if browser is not Internet Explorer
 */
function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
        // Edge (IE 12+) => return version number
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}

/***/ })

/******/ });