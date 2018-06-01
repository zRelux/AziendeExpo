function redirect(url) {
  window.location.href = url;
}

function search(ele) {
    if(event.key === 'Enter') {
        document.getElementById("ricercaAz").submit();
    }
}

function ricerca() {
  $("div#list").empty();
  var input;
  var res = {};
  res["type"] = {};
  res["id"] = {};
  var myJSON
  input = document.getElementById("ricercaAziende").value;
  if (input != '') {
    $.ajax({
      url: 'res/ricerca.php',
      type: 'POST',
      data: {
        input: input
      },
      dataType: "json",
      success: function(result) {
        var ul = document.getElementById("searchdropdown");
        while(ul.firstChild) ul.removeChild(ul.firstChild);
        var i = 0;
        var c = 1;
        var dataCountry = {};
        if(result.length == 0){
          res["type"][0] = "Nessun Risultato";
          //$("#searchdropdown").append('<li><a>Nessun Risultato</a></li>');
        }else
          while (i < result.length) {
              res["type"][c] = result[i];
              i++;
              res["id"][c] = result[i];
              i++;
              //$("#searchdropdown").append('<li><a href="profile.php?id=' + res["id"][c] + '">'+res["type"][c]+'</a></li>');
          }

      },

      error: function(data) {
        console.log(data);
      }

    });
  }
}

//To select country name

function copia(){
  var name = document.getElementById("testoDaCopiare").value;
  document.getElementById("progsubTitle").textContent=name;
}

function modify() {
  var elements = document.getElementsByClassName("immagine");
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].style.display == "none" || elements[i].style.display == "" || elements[i].style.display == " ") {
      elements[i].style.display = "block";
    } else if (elements[i].style.display == "block") {
      elements[i].style.display = "none";
    }
  }
  var elements = document.getElementsByClassName("invisibile");
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].style.display == "none" || elements[i].style.display == "" || elements[i].style.display == " ") {
      elements[i].style.display = "block";
    }
  }
  var elements = document.getElementsByClassName("m-text");
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].style.display == "none" || elements[i].style.display == "" || elements[i].style.display == " ") {
      elements[i].style.display = "block";
    }
    if (elements[i].contentEditable == "true") {
      elements[i].contentEditable = "false";
      elements[i].style = "";
    } else if (elements[i].contentEditable == "false") {
      elements[i].contentEditable = "true";
      elements[i].style = "border: 1px solid black";
    }
  }
}

function saveEdit() {
  var elements = document.getElementsByClassName("immagine");
  for (var i = 0; i < elements.length; i++) {
    if (elements[i].style.display == "block") {
      elements[i].style.display = "none";
    }
  }

  var elements = document.getElementsByClassName("m-text");
  var dati = new Array();
  var flag = true;
  for (var i = 0; i < elements.length; i++) {
    if ((i == 0) && (elements[i].textContent == ' ' || elements[i].textContent == '')) {
      alert("Il nome dell'impresa non può essere vuoto");
      flag = false;
    }
    if (i == 8 || i == 9) {
      dati.push(elements[i].textContent.replace('perm_phone_msg', '').replace('email', '').replace(/\s/g, ""));
    } else {
      dati.push(elements[i].textContent.replace('perm_phone_msg', '').replace('email', ''));
    }
    if (elements[i].contentEditable == "true") {
      elements[i].contentEditable = "false";
      elements[i].style = "";
    }
  }

  var data = {
    dati: dati.join('*'),
  };
  if (flag == true) {
    $.post("res/save.php", data);
  }
}

function savePost() {
  var elements = document.getElementsByClassName("m-text");
  var dati = new Array();
  for (var i = 0; i < elements.length; i++) {
    dati.push(elements[i].textContent);
    if (elements[i].contentEditable == "true") {
      elements[i].contentEditable = "false";
      elements[i].style = "";
    }
  }
  var data = {
    post: dati.join('*'),
  };
  $.post("res/save.php", data);
  window.location.href = "\profile.php?find=true";
}

function cancellaPost(id) {
  swal({
      title: "Conferma",
      text: "Sei sicuro di voler cancellare il post?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        var data = {
          cancella: id,
        };
        var post = $.post("res/delete.php", data);
        post.done(function(msg) {
        });
        swal("Poof! Il tuo post è stato cancellato", {
          icon: "success",
        }).then((value) => {
          switch (value) {
            default: location.reload();
          }
        });
      }
    });
}

$("#testoDaCopiare").on("keyup", function() {
  if (this.value != "")
    $("#progsubTitle").text($("#testoDaCopiare").value);
});

$('.dropdown-button').dropdown({
  hover: true,
  coverTrigger: false,
});

$(document).ready(function() {
  M.AutoInit();
});


/*$(document).ready(function() {
  $('.modal').modal();
  $('.collapsible').collapsible();
  $('.sidenav').sidenav();
  $('.dropdown-trigger').dropdown();
});*/


$(document).on('click', '#toast-container .toast', function() {
  $(this).remove();
});

function readURL(input) {
  var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
    var reader = new FileReader();
  reader.onload = function(e) {
    $('#img').attr('src', e.target.result);
  }

  reader.readAsDataURL(input.files[0]);
}

$("#testoDaCopiare").keyup(function() {
  var val = $(this).val();
  $(".card-title grey-text text-darken-4 testoDaModificare").html(val);
});
