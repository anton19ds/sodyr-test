$(document).ready(function (e) {
  $("#field").change(function (e) {
    if ($(this).val() != "0") {
      var re = / /g;
      var tename = $("#field option:selected").text();
      var name = tename.replace(re, "_");
      var field = "[fields id=" + $(this).val() + " name=" + name + "]";
      insertText("areaS", field);
    }
  });

  $(".itemEm").on("click", function (e) {
    var val = $(this).data("key");
    insertText("areaS", val);
  });

  // function insertText(id, text) {
  //   //ищем элемент по id
  //   var txtarea = document.getElementById(id);
  //   //ищем первое положение выделенного символа

  //   var textStart = getCursorPosition(txtarea);
  //   //ищем последнее положение выделенного символа

  //   // текст до + вставка + текст после (если этот код не работает, значит у вас несколько id)
  //   // var element = $('#'+id);

  //   var finText = element.value.substring(0, textStart) + text + element.value.substring(textStart);

  //   // подмена значения
  //   //console.log(finText);
  //   element.value = finText;
  //   // возвращаем фокус на элемент
  //   element.focus();
  //   // возвращаем курсор на место - учитываем выделили ли текст или просто курсор поставили
  //   // setCursorPosition(txtarea, textStart + text.length);
  //   // txtarea.selectionEnd = textStart;
  // }

  function insertText(id, text) {
    //ищем элемент по id
    var txtarea = document.getElementById(id);
    //ищем первое положение выделенного символа
    var start = txtarea.selectionStart;
    //ищем последнее положение выделенного символа
    var end = txtarea.selectionEnd;
    // текст до + вставка + текст после (если этот код не работает, значит у вас несколько id)
    var finText =
      txtarea.value.substring(0, start) + text + txtarea.value.substring(end);
    // подмена значения
    txtarea.value = finText;
    // возвращаем фокус на элемент
    txtarea.focus();
    // возвращаем курсор на место - учитываем выделили ли текст или просто курсор поставили
    txtarea.selectionEnd = start == end ? end + text.length : end;
  }

  $("#viewSender").change(function (e) {
    if ($(this).val() != "") {
      var id = $(this).data("template");
      window.open(
        "/panel/sender?template=" + id + "&id=" + $(this).val(),
        "_blank"
      );
    }
  });

  $("#addGrupol").on("click", function (e) {
    e.preventDefault();
    var col_param = $(".col_param").val();
    $.post("/panel/fields/add-pole", { col_param: col_param }, Success);
    var block = $(this);
    function Success(data) {
      block.before(data.form);
      $(".col_param").val(data.data);
    }
  });
});

$(document).on("click", ".delete-card", function (e) {
  e.preventDefault();
  $(this).closest(".card").remove();
});

$(document).on("click", ".sepModal", function (e) {
  e.preventDefault();
  var id = $(this).data("id");
  $.post("/panel/fields/red-template", { id: id }, Success);
  function Success(data) {
    $("#form-modal-body").html(data);
    $("#form_modal").modal("show");
  }
});

$(document).on("click", ".saveThis", function (e) {
  e.preventDefault();
  var form = $(this).closest("form").serializeArray();
  $.ajax({
    type: "POST",
    url: "/panel/fields/update-template",
    data: form,
    success: function (data) {
      $("#form_modal").modal("hide");
      $.pjax.reload("#modal-bord");
    },
  });
});

$(document).on("click", ".add-param", function (e) {
  e.preventDefault();
  var is = $(this).data('is');
  var count = $(".count_param_"+is).val();
  $.post("/panel/templates/add-param", { count: count, is: is }, Success);
  function Success(data) {
    $(".chor_"+is).prepend(data.form);
    $(".count_param_"+is).val(data.data);
    // $(".count_param").val(data.data);
  }
});
$(document).on("click", ".or-param", function (e) {
  e.preventDefault();
  var count = $(".array_param").val();
  $.post("/panel/templates/or-param", { count: count }, Success);
  function Success(data) {
    $(".ester").prepend(data.form);
    $(".array_param").val(data.data);
  }
});

$(document).on("click", ".delser-block", function (e) {
  e.preventDefault();
  var zet = $(this).data('zet');
  
  if($(this).closest('.sevort').find('.delser-block').length == 1){
    $(this).closest('.sevort').remove();
  }
  $(".stroks_"+zet).remove();
  
});

$(document).on("click", ".fogot", function (e) {
  e.preventDefault();
  $(this).closest(".card-body").find("input.after").val("end fields");
});

$(document).on("click", "#areaS", function (e) {
  //ищем элемент по id
  var txtarea = document.getElementById("areaS");
  var tesrt = $("#areaS").val();
  //ищем первое положение выделенного символа
  var textStart = txtarea.selectionStart;

  console.log(textStart);
  // console.log(tesrt.substr(0, textStart));
  var strStart = tesrt.substr(0, textStart);
  var strEnd = tesrt.substring(textStart);

  // console.log(strStart);
  // console.log(strEnd);
  var rirstSymbol = strStart.lastIndexOf("[");
  var endSymbo = strEnd.indexOf("]");
  var lastFer =
    strStart.substring(rirstSymbol) + strEnd.substr(0, endSymbo + 1);
  var ch = "id";
  var count = lastFer.split(ch).length - 1;

  if (count == 1) {
    //$('#pervods').val(lastFer);
    // console.log(lastFer);
    var text = lastFer.split(" ");
    $.each(text, function (index, value) {
      var count = value.split("id=").length - 1;
      if (count == 1) {
        var set = value.split("=");
        $("#idField").val(set[1]);
      }

      var lert = value.split("palseholder=").length - 1;
      if (lert == 1) {
        var sets = value.split("=");
        var textNewS = sets[1].replace("_", " ");
        $("#pervods").val(textNewS);
      }
    });
  }

  // var start = txtarea.selectionStart;
  //ищем последнее положение выделенного символа
  // var end = txtarea.selectionEnd;
  // текст до + вставка + текст после (если этот код не работает, значит у вас несколько id)
  // console.log(start);
  // var finText =
  //   txtarea.value.substring(0, start) + text + txtarea.value.substring(end);
  // подмена значения
  // txtarea.value = finText;
  // возвращаем фокус на элемент
  // txtarea.focus();
  // возвращаем курсор на место - учитываем выделили ли текст или просто курсор поставили
  // txtarea.selectionEnd = start == end ? end + text.length : end;
});
$(document).on("click", ".root-shot", function (e) {
  e.preventDefault();
  var id = $("#idField").val();
  var text = $("#pervods").val();
  var tesrt = $("#areaS").val();

  if (id != "" && text != "") {
    var re = / /g;
    let regexp = /\s/;
    var textNew = text.replace(re, "_");
    // var fet = tesrt.split('id='+id).join('id='+id+' '+'palseholder='+textNew+' ');
    // var fetr = tesrt.split(' ');
    var getSymbol = tesrt.indexOf("id=" + id);
    strEnd = tesrt.substring(getSymbol);
    strStart = tesrt.substr(0, getSymbol);
    // console.log(strStart);
    // console.log(strEnd);

    var rirstSymbol = strStart.lastIndexOf("[");
    var endSymbol = strEnd.indexOf("]");

    //console.log(endSymbol);
    // console.log(rirstSymbol);
    strA = strStart.substring(rirstSymbol);

    strS = strEnd.substring(0, endSymbol + 1);
    var regity = strA + strS;
    var obj = regity.split(" ");
    // $.each(obj, function (index, value) {
    //   // var count = value.split(' ');
    //   console.log(value+'  '+index);

    //   if(value.indexOf('palseholder')+1){
    //     obj.splice(index, 1);
    //   }
    // });

    obj = obj.filter(function (item) {
      return item.indexOf("palseholder") === -1;
    });

    obj.splice(2, 0, "palseholder=" + textNew);
    var string = obj.join(" ");
    var fet = tesrt.split(regity).join(string);
    // console.log(fet);
    $("#areaS").val(fet);
    // $.each(fetr, function (index, value) {
    //   console.log(typeof value);
    //   var count = value.split('palseholder=').length - 1;
    //   if(count == 1){

    //   }
    // });

    //$('#areaS').val(fet);
    // var fet = fetr.join(' ');

    // var vare = fet.split('id='+id).join('id='+id+' '+'palseholder='+textNew+'  ');
    // console.log(vare);
    // $('#areaS').val(vare);
  }
});

function getCursorPosition(parent) {
  let selection = document.getSelection();
  let range = new Range();
  range.setStart(parent, 0);
  range.setEnd(selection.anchorNode, selection.anchorOffset);
  return range.toString().length;
}

function setCursorPosition(parent, position) {
  let child = parent.firstChild;
  while (position > 0) {
    let length = child.textContent.length;
    if (position > length) {
      position -= length;
      child = child.nextSibling;
    } else {
      if (child.nodeType == 3)
        return document.getSelection().collapse(child, position);
      child = child.firstChild;
    }
  }
}

// $(document).on("click", ".styleB", function (e) {
//   e.preventDefault();
//   if (window.getSelection() == "") {
//     return false;
//   }
//   var start = txtarea.selectionStart;
//     //ищем последнее положение выделенного символа
//   var end = txtarea.selectionEnd;

//   return false;
// });
// bisu
$(document).on("click", ".styleB", function (e) {
  e.preventDefault();
  var txtarea = document.getElementById('areaS');
  if (txtarea.selectionStart == txtarea.selectionEnd) {
    return; // ничего не выделено
  }
  let selected = txtarea.value.slice(txtarea.selectionStart, txtarea.selectionEnd);
  if($(this).hasClass('re-bold')){
    txtarea.setRangeText(`<b>${selected}</b>`);
  }
  if($(this).hasClass('re-ital')){
    txtarea.setRangeText(`<i>${selected}</i>`);
  }
  if($(this).hasClass('re-seld')){
    txtarea.setRangeText(`<s>${selected}</s>`);
  }
  if($(this).hasClass('re-under')){
    txtarea.setRangeText(`<u>${selected}</u>`);
  }
  
  
});