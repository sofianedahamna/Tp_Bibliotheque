<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="../../assets/js/jquery3.6.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script type="text/javascript">
        $(document).ready(function() {

            /*===================================================
             *    Fonction de soumission des données formulaire
             ===================================================*/
            var ajaxOptions = {
                method: "POST",
                cache: false,
                async: true,
                timeout: 3000,
                dataType: "json",
                processData: false,
                contentType: false
            };

            let resetInputSearch = function() {
                $("#list_completion option").remove(".opt-complete");
            };

            $("input[type='text']").keydown(function(e) {
                if (e.keyCode != 8 || e.which != 8) {
                    var inputTxt = $(this).val();
                    let formSearch = $("#form_search_Catalogue")[0];
                    if (inputTxt.length >= 1) {
                        ajaxOptions.dataType = "json";
                        ajaxOptions.url = formSearch.getAttribute("action");
                        let fd = new FormData(formSearch);
                        //ajaxOptions.data = {"keyword": inputTxt, "action": "rechercher"};
                        ajaxOptions.data = fd;
                        let response = "";
                        $.ajax(ajaxOptions).done(function(callback) {
                            resetInputSearch();
                            for (let position in callback) {
                                response += `<option class='opt-complete '>  ${callback[position].denomination} </option>`;
                            }
                            $("#list_completion").append(response);
                        }).fail(function() {

                        }).always(function() {

                        });
                        fd = null;
                    }
                } else {
                    resetInputSearch();
                }
            });

            /**   $("output").on("click", "img[id^='btn_img_']", function(e) {
                  let categorie= $(this).data("reference");
                  let dataR = {
                      "ref": categorie,
                      "action": "rechercher"
                  }
                  $.post("../controlleur/searchController.php",dataR, function(categorie) {
                      alert("Information complementaire: " + categorie);
                  });
              });
              */
            /********************************************************************************
             *              Fonction Enregistrement des données client est donnée Donuts    *
             ********************************************************************************/
            function inscriptionClient() {

                var form = $("#form_inscription").get(0);
                var url = form.getAttribute("action");
                var formData = new FormData(form);
                ajaxOptions.data = formData;
                ajaxOptions.url = url;
                $.ajax(ajaxOptions).done(function(clbck) {
                    if (clbck.err_flag) {
                        alert(clbck.err_msg);
                    } else {
                        console.log(flag_response);
                        let flag_response = "Les donnée ont été enregistrées!";
                        launchDialogInfo(flag_response);
                        reset_form();
                    }
                    dis_panel_flw();
                }).fail(function(e) {
                    console.log(e);
                    alert("Error!");
                }).always(function() {
                    //dis_panel_flw();
                });
            };
            $("#form_inscription").submit(function(e) {
                e.preventDefault();
                inscriptionClient();
            });
            let launchDialogInfo = function(elemetText) {
                    $("#dialogInfo div.modal-body").html(elemetText);
                    $("#btn_show_dialog_info").click();
                }


            $("#form_search_Catalogue").submit(function(e) {
                e.preventDefault();
                searchCatalogue();


            });
            var searchCatalogue = function() {
                var formSearchCatalogue = $("#form_search_Catalogue")[0];
                var url = formSearchCatalogue.getAttribute('action');
                var formData = new FormData(formSearchCatalogue);
                ajaxOptions.data = formData;
                ajaxOptions.url = url;
                $.ajax(ajaxOptions).done(function(tab_article) {
                    $("tbody[id='tbody_result_donuts'] tr").remove(".ajust");
                    $("tbody[id='tbody_result_donuts'] td").remove(".ajust");
                    //alert(tab_article[0].Reference);

                    if (tab_article) {
                        let response = "";
                        $("#tbl_result_donuts").removeClass("dsply-no").fadeIn(function() {
                            for (var position in tab_article) {
                                response += `<tr class='ajust'>
                                 <td>  ${(parseInt(position) + 1)} </td>
                                <td>  ${tab_article[position].reference} </td>
                                <td>  ${tab_article[position].denomination} </td>
                                <td>  ${tab_article[position].categorie} </td>
                                <td> <button> <img id='btn_img_" ${tab_article[position].reference} "' src='../../assets/icone/icons8-loupe-32.png' alt=''data-bs-toggle="modal" data-bs-target="#dialogInfo" data-reference='${tab_article[position].reference}'></button> </td>
                            </tr>`;
                            }
                            $("tbody[id='tbody_result_donuts']").append(response);
                        });
                    } else {
                        launchDialogInfo("Aucun résultats trouvé!");
                    }
                }).fail(function() {
                    alert("Une erreur est survenue lors de l'envoie des donnés!");
                }).always(function() {
                    //dis_panel_flw();
                });
            };

            /**remplissage de tableau selon les different objet retourner par le manager en fonction de la categorie envoyer au controller */
           $("#output").on("click", "img[id^='btn_img_']", function() {
                $(".ajust1").remove();
                let reference = $(this).attr("data-reference");
                //console.log(reference.length);
                let formSearch = $("#form_search_Catalogue")[0];
                var url = formSearch.getAttribute("action");
                ajaxOptions.url = url;
                selectData = $("#slct_cvlt").val();
                //console.log(selectData);
                ajaxOptions.data = {
                    "type": selectData,
                    "reference":reference,
                    "action": "rechercherInfo",
                };
                ajaxOptions.method = "POST";
                ajaxOptions.dataType = "json";
                ajaxOptions.processData = true;
                ajaxOptions.contentType = formSearch.getAttribute("enctype");

                 //console.log(ajaxOptions);
                $.ajax(ajaxOptions).done(function(tab_article) {
                    for (var position in tab_article) {
                       /// console.log(tab_article[position].categorie);
                        if (tab_article[position].categorie == "Livre") {
                            responseModal =`<div class='ajust1' data-reference=  ${tab_article[position]. categorie}  >\n\
                                                <p> Categorie :   ${tab_article[position].categorie}  </p>\n\
                                                <p> Reference :   ${tab_article[position].reference}  </p>\n\
                                                <p> Denomination :   ${tab_article[position].denomination} </p>\n\
                                                <p> Auteur :   ${tab_article[position].autheur}  </p>\n\
                                                <p> Resumer :   ${tab_article[position].resumer}  </p>\n\
                                                \n\
                                            </div>`;
                        } else if (tab_article[position].categorie == "CD") {
                            responseModal =
                            `<div class='ajust1' data-reference=  ${tab_article[position]. categorie}  >\n\
                                                <p> Categorie :   ${tab_article[position].categorie}  </p>\n\
                                                <p> Reference :   ${tab_article[position].reference}  </p>\n\
                                                <p> Denomination :   ${tab_article[position].denomination} </p>\n\
                                                <p> Compositeur :   ${tab_article[position].compositeur}  </p>\n\
                                                <p> Tracklist :   ${tab_article[position].Tracklist}  </p>\n\
                                                \n\
                                            </div>`;
                        } else if (tab_article[position].categorie == "DVD") {
                            responseModal = `<div class='ajust1' data-reference=  ${tab_article[position]. categorie}  >\n\
                                                <p> Categorie :   ${tab_article[position].categorie}  </p>\n\
                                                <p> Reference :   ${tab_article[position].reference}  </p>\n\
                                                <p> Denomination :   ${tab_article[position].denomination} </p>\n\
                                                <p> Realisateur :   ${tab_article[position].realisateur}  </p>\n\
                                                <p> Synopsis :   ${tab_article[position].synopsis}  </p>\n\
                                                \n\
                                            </div>`;
                        }

                    }

                    $(".modal-body").append(responseModal);
                    alert("Données transmises!");
                }).fail(function() {
                    alert("Erreur lors de l'adressage des données!");
                }).always(function() {

                });
            })  
            /**function permetant d'ajouter ou d'enlever la class dsply-no sur les section a afficher en fonction de l'appel depuis le menu header*/
            function select_content_sctn(id_tab) {
                $("section[id^='sctn_tab_']").addClass("dsply-no").stop(true, true).fadeOut("fast", function(e) {
                    $("section[id='sctn_tab_" + id_tab + "']").stop(true, true).removeClass("dsply-no").fadeIn();
                });
            }


            $(" nav li.nav-item:not(#no_load)").click(function(e) {
                e.preventDefault();
                let id_tab = $(this).attr("data-sctn-id");
                select_content_sctn(id_tab);
            });


            /** fonction de logout */
            $("li[id='btn_actn_logout'] ").click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "http://localhost/dossier_type_mvc/application/view/authentification.php",
                    method: "POST",
                    data: {
                        "action": "logout"
                    }
                }).done(function() {

                }).fail(function() {

                }).always(function() {

                });
            });

           
        });
    </script>
    <style>
        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        main {
            min-width: 100%;
            min-height: 100%;
        }

        #ctn_div_central {
            width: 100%;
            padding: 0px;
        }

        section[id^="sctn_tab_"] {
            width: 100%;
            padding: 0px 80px;
            margin: 40px 0px;
        }

        /**  .ms-auto{
                 margin-right: 50px !important;
            }
*/
        nav.mr-2 {
            margin-right: 20px !important;
        }


        /*            .dsply-no{
                            display: none;
                        }*/

        #ss_ctn_from {
            display: table;
            width: 100%;
            border-spacing: 25px;
        }

        #ss_ctn_from_left {
            display: table-cell;
        }

        .dsply-no {
            display: none !important;
        }

        #slct_cvlt {
            width: 145px;
        }

        input[type=date] {
            width: 150px;
        }

        .header {
            background-color: #343a40 !important;
        }

        #ctn_form_search {
            width: 500px !important;
        }

        #output {
            width: 100% !important;
        }

        /* configuration des fenêtres modales */
        .modal-header {
            padding: 0.5rem 0.5rem !important;
        }

        /*Réajustement de positionnement de la fenêtre modal au centre */
        #dialogInfo .modal-dialog {
            position: fixed;
            width: 100% !important;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /*Ajustement sur le tableau de résultat*/

        #tbl_result tbody tr:hover {
            background-color: #fdd;
            transition-delay: 0s;
            transition-duration: 1s;
            transition-property: all;
        }

        #tbl_result tr {
            text-align: center;
        }

        header {
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(8, 28, 133, 1) 41%, rgba(0, 212, 255, 1) 100%);
        }

        h1 {
            text-align: center;
        }

        #offcanvas_sctn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 550px;
            min-height: 450px;
            max-height: 450px;
        }
        .modal-dialog{
            overflow-y: scroll;
            min-height: 500px;
            min-width: 600px;
        }

        


        button.btn-close {
            position: absolute;
            top: 0px;
            right: 0px;
            margin: 5px !important;

        }
    </style>
</head>

<body>
    <header class="navbar navbar-expand-md navbar-dark header">
        <section class="navbar">

        </section>
        <section class="navbar ms-auto ">
            <nav class="mr-2">
                <ul class="navbar-nav nav-pills justify-content-center ">
                    <!--         <li class="nav-item dropdown" id="no_load">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Compte</a>
                                <ul id="menu_prcpl" class="dropdown-menu dropdown" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Paramètres</a></li>
                                    <li id="btn_actn_logout"><a class="dropdown-item" href="#">Déconnexion</a></li>
                                </ul>  
                            </li>  -->
                    <li data-sctn-id="1" class="nav-item">
                        <a class="nav-link " href="#">Consulter Reference</a>
                    </li>
                    <li data-bs-toggle="offcanvas" data-bs-target="#offcanvas_sctn" class="nav-item">
                        <a class="nav-link " href="#">Reserver</a>
                    </li>
                    <li data-bs-toggle="offcanvas" data-bs-target="#offcanvas_sctn" class="nav-item">
                        <a class="nav-link " href="#">Emprunter</a>
                    </li>
                </ul>
            </nav>
        </section>
    </header>
    <!--DEBUT formulaire de recherche catalogue-->
    <h1>Repertoire de la Bibliothèque</h1>
    <section id="sctn_tab_1" class="dsply-no " data-sctn-id="1">
        <div id="ctn_form_search_Donuts" class="mx-auto">
            <form formtarget="_self" name="form_search_Catalogue" id="form_search_Catalogue" action="../controlleur/searchController.php" method="POST" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="action" value="rechercherArticle">
                <div class="input-group">
                    <input class="form-control w-25 " type="text" id="keyword" name="keyword" placeholder="rechercher" autocomplete="off" list="list_completion">
                    <datalist id="list_completion"></datalist>
                    <select name="type" class="form-select" id="slct_cvlt">
                        <option value="Tous_Type" selected="selected">--- Tous Type ---</option>
                        <option value="DVD">DVD</option>
                        <option value="LIVRE">Livre</option>
                        <option value="CD">CD</option>
                    </select>
                    <button class="btn btn-primary btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <output id="output" class="mt-4">
            <table id="tbl_result_donuts" class="table table-striped dsply-no">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>reference</th>
                        <th>denomination</th>
                        <th>categorie</th>
                        <th>description</th>
                    </tr>
                </thead>
                <tbody id="tbody_result_donuts"></tbody>
            </table>
        </output>
    </section>
    </main>
    <section class="offcanvas fade offcanvas-end p-4 rounded" id="offcanvas_sctn">
        <section class="offcanvas-header">
            <h2 class="offcanvas-title">Formulaire Inscription</h2>
            <button class="btn  btn-close" data-bs-dismiss="offcanvas"></button>
        </section>
        <section class="offcanvas-body">
            <form method="post" action="../controlleur/inscriptionController.php" enctype="application/x-www-form-urlencoded" target="application\view\authentification.php" id="form_inscription">
            <input type="hidden" name="action" value="inscription">
            <input  type="hidden" type="date" name="dateInscriptionClient_utlstr" value="<?php echo date('Y-m-d'); ?>">
            <div class="mb-3 form-floating">
                <select class="form-select" name="civiliter_utlstr" id="civiliter_frm_iscrpt">
                    <option disabled="disabled" selected="selected">-- Civilité --</option>
                    <option value="mdm">Madame</option>
                    <option value="mr">Monsieur</option>
                    <option value="indf">Indéfini</option>
                </select> 
                <label for="civiliter_utlstr" >Civilité</label>
            </div>
                <div>
                    <label class="form-label w-50" for="nom_utlstr">Nom</label>
                    <input class="form-input" id="nom_utlstr" name="nom_utlstr" type="text">
                </div>
                <div>
                    <label class="form-label w-50"  for="prenom_utlstr">prénom</label>
                    <input class="form-input" id="prenom_utlstr" name="prenom_utlstr" type="text">
                </div>
                <div>
                    <label class="form-label w-50"  for="numDeVoie_utlstr">N° de voie</label>
                    <input class="form-input" id="numDeVoie_utlstr" name="numDeVoie_utlstr" type="text">
                </div>
                <div>
                    <label class="form-label w-50"  for="libelleVoie_utlstr">Libellé de voie </label>
                    <input class="form-input" id="libelleVoie_utlstr" name="libelleVoie_utlstr" type="text">
                </div>
                <div>
                    <label class="form-label w-50"  for="ville_utlstr">Ville </label>
                    <input class="form-input" id="ville_utlstr" name="ville_utlstr" type="text">
                </div>
                <div>
                    <label class="form-label w-50"  for="codePostal_utlstr">Code postal</label>
                    <input class="form-input" id="codePostal_utlstr" name="codePostal_utlstr" type="text">
                </div>
                <div>
                    <label class="form-label w-50"  for="email_utlstr">Email</label>
                    <input class="form-input" id="email_utlstr" name="email_utlstr" type="text" placeholder="Votre email"
                       pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" 
                       title="Email non valide!" required="">
                </div>
                <div>
                    <label class="form-label w-50" for="telephone_utlstr">telephone</label>
                    <input class="form-input" id="telephone_utlstr" name="telephone_utlstr" type="text">
                </div>
                <div>
                    <input class="btn btn-dark" type="submit" value="Submit">
                    <input class="btn btn-primary" type="reset" value="Reset">
                </div>
            </form>
        </section>
    </section>
    <footer>
    </footer>
    <!--FIN formulaire de recherche catalogue-->
    <!-- Start Popupmodal infos -->
    <span id="btn_show_dialog_info" data-bs-toggle="modal" data-bs-target="#dialogInfo"></span>
    <div id="dialogInfo" class="modal">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-content">
                <div class="modal-header bg-light">
                    <div class="h6 modal-title">Informations</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <!-- Stop Popupmodal infos -->
</body>


</html>