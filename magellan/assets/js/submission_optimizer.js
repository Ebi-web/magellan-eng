// ユーザー入力フォームにおいてクォーテーション・改行コードの入力を
// 認めないJS.ページ内にform要素は1つであると仮定
"use strict";
let formObj = document.forms[0];//the target form element
const inputs = document.querySelectorAll("input[type='text']");//All input elements as NodeList
const prohibits = [/"/, /'/, /\r/, /\n/];//Array expected to be error
const warning = "システムエラーとなる可能性があるため，クォーテーションマークや一部の特殊文字は使用できません";//error message
formObj.setAttribute("onsubmit", "return validation()");
function validation() {
    $("button[type='submit']").prop("disabled", true);
    setTimeout(function () {
        $("button[type='submit']").prop("disabled", false);
    }, 10000); //二重submitの防止
    for (let input of inputs) {
        if (prohibits.some((regexp) => { if (regexp.test(input.value)) { window.alert(warning); return true; } })) {
            return false;
        }
    }
};//配列prohibitsにユーザーの入力値がmatchしていたらonsubmitがreturn falseする
