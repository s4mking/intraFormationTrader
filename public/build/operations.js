(self["webpackChunk"] = self["webpackChunk"] || []).push([["operations"],{

/***/ "./assets/script/operations.js":
/*!*************************************!*\
  !*** ./assets/script/operations.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.array.push.js */ "./node_modules/core-js/modules/es.array.push.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
__webpack_require__(/*! core-js/modules/es.json.stringify.js */ "./node_modules/core-js/modules/es.json.stringify.js");
document.querySelector('#removeOperations').addEventListener("click", function () {
  var array = [];
  var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
  for (var i = 0; i < checkboxes.length; i++) {
    array.push(checkboxes[i].id);
  }
  var urlCallAjax = location.protocol + '//' + location.host + '/operation/removeoperations';
  // Making our request
  fetch(urlCallAjax, {
    method: 'POST',
    body: JSON.stringify(array)
  }).then(function (Result) {
    return Result.json();
  }).then(function (string) {
    // Printing our response
    window.location.reload();
  })["catch"](function (errorMsg) {
    console.log(errorMsg);
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_export_js-node_modules_core-js_internals_function-bind-5e17a2","vendors-node_modules_core-js_modules_es_array_push_js-node_modules_core-js_modules_es_json_st-63d8f3"], () => (__webpack_exec__("./assets/script/operations.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoib3BlcmF0aW9ucy5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7QUFBQUEsUUFBUSxDQUFDQyxhQUFhLENBQUMsbUJBQW1CLENBQUMsQ0FBQ0MsZ0JBQWdCLENBQUMsT0FBTyxFQUFFLFlBQVU7RUFDOUUsSUFBSUMsS0FBSyxHQUFHLEVBQUU7RUFDZCxJQUFJQyxVQUFVLEdBQUdKLFFBQVEsQ0FBQ0ssZ0JBQWdCLENBQUMsOEJBQThCLENBQUM7RUFFMUUsS0FBSyxJQUFJQyxDQUFDLEdBQUcsQ0FBQyxFQUFFQSxDQUFDLEdBQUdGLFVBQVUsQ0FBQ0csTUFBTSxFQUFFRCxDQUFDLEVBQUUsRUFBRTtJQUMxQ0gsS0FBSyxDQUFDSyxJQUFJLENBQUNKLFVBQVUsQ0FBQ0UsQ0FBQyxDQUFDLENBQUNHLEVBQUUsQ0FBQztFQUM5QjtFQUVBLElBQUlDLFdBQVcsR0FBR0MsUUFBUSxDQUFDQyxRQUFRLEdBQUcsSUFBSSxHQUFHRCxRQUFRLENBQUNFLElBQUksR0FBRyw2QkFBNkI7RUFDNUY7RUFDRUMsS0FBSyxDQUFDSixXQUFXLEVBQUU7SUFBRUssTUFBTSxFQUFFLE1BQU07SUFBRUMsSUFBSSxFQUFFQyxJQUFJLENBQUNDLFNBQVMsQ0FBQ2YsS0FBSztFQUFFLENBQUMsQ0FBQyxDQUNoRWdCLElBQUksQ0FBQyxVQUFBQyxNQUFNO0lBQUEsT0FBSUEsTUFBTSxDQUFDQyxJQUFJLENBQUMsQ0FBQztFQUFBLEVBQUMsQ0FDN0JGLElBQUksQ0FBQyxVQUFBRyxNQUFNLEVBQUk7SUFFZDtJQUNBQyxNQUFNLENBQUNaLFFBQVEsQ0FBQ2EsTUFBTSxDQUFDLENBQUM7RUFDMUIsQ0FBQyxDQUFDLFNBQ0ksQ0FBQyxVQUFBQyxRQUFRLEVBQUk7SUFBRUMsT0FBTyxDQUFDQyxHQUFHLENBQUNGLFFBQVEsQ0FBQztFQUFFLENBQUMsQ0FBQztBQUNsRCxDQUFDLENBQUMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvc2NyaXB0L29wZXJhdGlvbnMuanMiXSwic291cmNlc0NvbnRlbnQiOlsiZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3JlbW92ZU9wZXJhdGlvbnMnKS5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgZnVuY3Rpb24oKXtcbiAgdmFyIGFycmF5ID0gW11cbiAgdmFyIGNoZWNrYm94ZXMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCdpbnB1dFt0eXBlPWNoZWNrYm94XTpjaGVja2VkJylcblxuICBmb3IgKHZhciBpID0gMDsgaSA8IGNoZWNrYm94ZXMubGVuZ3RoOyBpKyspIHtcbiAgICBhcnJheS5wdXNoKGNoZWNrYm94ZXNbaV0uaWQpXG4gIH1cblxuICBsZXQgdXJsQ2FsbEFqYXggPSBsb2NhdGlvbi5wcm90b2NvbCArICcvLycgKyBsb2NhdGlvbi5ob3N0ICsgJy9vcGVyYXRpb24vcmVtb3Zlb3BlcmF0aW9ucyc7XG4vLyBNYWtpbmcgb3VyIHJlcXVlc3RcbiAgZmV0Y2godXJsQ2FsbEFqYXgsIHsgbWV0aG9kOiAnUE9TVCcsIGJvZHk6IEpTT04uc3RyaW5naWZ5KGFycmF5KSB9KVxuICAgIC50aGVuKFJlc3VsdCA9PiBSZXN1bHQuanNvbigpKVxuICAgIC50aGVuKHN0cmluZyA9PiB7XG5cbiAgICAgIC8vIFByaW50aW5nIG91ciByZXNwb25zZVxuICAgICAgd2luZG93LmxvY2F0aW9uLnJlbG9hZCgpXG4gICAgfSlcbiAgICAuY2F0Y2goZXJyb3JNc2cgPT4geyBjb25zb2xlLmxvZyhlcnJvck1zZyk7IH0pO1xufSk7XG4iXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwiYWRkRXZlbnRMaXN0ZW5lciIsImFycmF5IiwiY2hlY2tib3hlcyIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJpIiwibGVuZ3RoIiwicHVzaCIsImlkIiwidXJsQ2FsbEFqYXgiLCJsb2NhdGlvbiIsInByb3RvY29sIiwiaG9zdCIsImZldGNoIiwibWV0aG9kIiwiYm9keSIsIkpTT04iLCJzdHJpbmdpZnkiLCJ0aGVuIiwiUmVzdWx0IiwianNvbiIsInN0cmluZyIsIndpbmRvdyIsInJlbG9hZCIsImVycm9yTXNnIiwiY29uc29sZSIsImxvZyJdLCJzb3VyY2VSb290IjoiIn0=