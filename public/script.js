const { data } = require("alpinejs");

window.onload = function() {
            displayPartenaire();
        }

// Ajouter une nouvelle ligne d'activité
function addStepRow() {

    const table = document.getElementById("activities-table");
    const rowCount = table.rows.length + 1;
    var trash_icon = $("#trash_icon").val();
    const newRow = `
        <tr>
            <th scope="row">${rowCount}</th>
            <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité"></td>
            <td><input type="date" name="dates_indicatives[]" class="form-control"></td>
        </tr>`;

    table.insertAdjacentHTML("beforeend", newRow);
}

// Fonction pour ajouter une nouvelle banque
function addActivityRow() {
    const tableBody = document.querySelector('#activityTable tbody');
    const newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();
    newRow.innerHTML = `
        <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité"></td>
        <td><input type="date" name="dates_indicatives[]" class="form-control" placeholder="jj/mm/aaaa"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Ajouter un nouveau promoteur
function addPromoteurRow(){
    var nombre_promoteur = $("#nombre_promoteur").val();
    var trash_icon = $("#trash_icon").val();
    $.ajax({
        type:'get',
        url:"/add/promoteur",
        dataType:'html',
        data:{nombre_promoteur:nombre_promoteur, trash_icon:trash_icon},
        error:function(){ alert("Erreur");},
        success:function(response){
            const promoteur = document.getElementById("promoteurs");
            promoteur.insertAdjacentHTML("beforeend", response);
        }
    });

    $("#nombre_promoteur").val(parseInt(nombre_promoteur)+1);

}

// Fonction pour ajouter un nouveau employe
function addEmployeRow() {
    var tableBody = document.querySelector('#personnelTable tbody');
    var newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="poste[]" placeholder="Poste"></td>
        <td><input type="text" class="form-control" name="qualification[]" placeholder="Qualification"></td>
        <td><input type="number" min="0" class="form-control" name="effectif[]" placeholder="Effectif"></td>
        <td><input type="text" min="0" class="form-control" name="salaire[]" placeholder="Salaires mensuels"></td>
        <td><textarea class="form-control" name="taches[]" placeholder="Tâches prévues"></textarea></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter un nouveau employe
function addEmployeRecruterRow() {
    var tableBody = document.querySelector('#personnelRecruterTable tbody');
    var newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="poste_rec[]" placeholder="Poste"></td>
        <td><input type="text" class="form-control" name="qualification_rec[]" placeholder="Qualification"></td>
        <td><input type="number" min="0" class="form-control" name="effectif_rec[]" placeholder="Effectif"></td>
        <td><input type="text" min="0" class="form-control" name="salaire_rec[]" placeholder="Salaires mensuels"></td>
        <td><textarea class="form-control" name="taches_rec[]" placeholder="Tâches prévues"></textarea></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle estimation
function addEstimationRow() {
    var tableBody = document.querySelector('#estimationTable tbody');
    var newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="produits[]" placeholder="Produit"></td>
        <td><input type="text" class="form-control" name="an_1[]" placeholder="Montant"></td>
        <td><input type="text" min="0" class="form-control" name="an_2[]" placeholder="Montant"></td>
        <td><input type="text" min="0" class="form-control" name="an_3[]" placeholder="Montant"></td>
        <td><input type="text" class="form-control" name="an_4[]" placeholder="Montant"></td>
        <td><input type="text" class="form-control" name="an_5[]" placeholder="Montant"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle estimation de la première année
function addEstimationFirstRow() {
    var tableBody = document.querySelector('#estimationFirstTable tbody');
    var newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();
    var ca = $("#chiffre_affaire_first_years").val();
    $("#chiffre_affaire_first_years").val(parseInt(ca)+1);

    newRow.innerHTML = `
        <td><input type="hidden" name="produit_first[]"><input type="text" class="form-control" name="produit[]" placeholder="Produit"></td>
        <td><input type="text" class="form-control" name="unite_first[]" placeholder="Forfait"></td>
        <td><input type="number" min="0" id="quantite_first_${ca}" class="form-control" name="quantite_first[]" onkeyup="calculeChiffre('quantite_first_${ca}', 'prix_unitaire_first_${ca}', 'chiffre_affaire_first_${ca}');" onclick="calculeChiffre('quantite_first_${ca}', 'prix_unitaire_first_${ca}', 'chiffre_affaire_first_${ca}');" value="0"></td>
        <td><input type="text" min="0" id="prix_unitaire_first_${ca}" class="form-control" name="prix_unitaire_first[]" onkeyup="calculeChiffre('quantite_first_${ca}', 'prix_unitaire_first_${ca}', 'chiffre_affaire_first_${ca}');" onclick="calculeChiffre('quantite_first_${ca}', 'prix_unitaire_first_${ca}', 'chiffre_affaire_first_${ca}');" value="0"></td>
        <td><input type="text" min="0" id="chiffre_affaire_first_${ca}" class="form-control" name="chiffre_affaire_first[]" value="0"></td>
        <td><input type="number" min="0" id="pourcentage_first" class="form-control" name="pourcentage_first[]" placeholder="00"></td>
        <td><button type="button" class="btn btn-danger btn-sm btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter un nouveau service exterieur
function addServiceExterieurRow() {
    var tableBody = document.querySelector('#serviceExterieurTable tbody');
    var newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    var se = $("#service_exterieur").val();
    $("#service_exterieur").val(parseInt(se)+1);

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="designation_service_exterieur[]" placeholder="Désignation"></td>
        <td><input type="text" class="form-control" name="unite_service_exterieur[]" placeholder="Unité"></td>
        <td><input type="number" min="0" id="quantite_service_exterieur_${se}" class="form-control" name="quantite_service_exterieur[]" onkeyup="calculeChiffre('quantite_service_exterieur_${se}', 'cout_unitaire_service_exterieur_${se}', 'cout_total_service_exterieur_${se}');" onclick="calculeChiffre('quantite_service_exterieur_${se}', 'cout_unitaire_service_exterieur_${se}', 'cout_total_service_exterieur_${se}');" value="0"></td>
        <td><input type="text" min="0" id="cout_unitaire_service_exterieur_${se}" class="form-control" name="cout_unitaire_service_exterieur[]" onkeyup="calculeChiffre('quantite_service_exterieur_${se}', 'cout_unitaire_service_exterieur_${se}', 'cout_total_service_exterieur_${se}');" onclick="calculeChiffre('quantite_service_exterieur_${se}', 'cout_unitaire_service_exterieur_${se}', 'cout_total_service_exterieur_${se}');" value="0"></td>
        <td><input type="text" id="cout_total_service_exterieur_${se}" class="form-control" name="cout_total_service_exterieur[]" disabled></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle estimation
function addChargeExisteRow(index) {
    var tableBody = document.querySelector('#chargeExisteTable'+index+' tbody');
    var newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();
    var charge = $("#charge_existe"+index).val();
    $("#charge_existe"+index).val(parseInt(charge)+1);

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="designation_charge_existe${index}[]" placeholder="Désignation"></td>
        <td><input type="text" class="form-control" name="unite_charge_existe${index}[]" placeholder="Unité"></td>
        <td><input type="number" min="0" id="quantite_charge_existe${index}_${charge}" class="form-control" name="quantite_charge_existe${index}[]" onkeyup="calculeChiffre('quantite_charge_existe${index}_${charge}', 'cout_unitaire_charge_existe${index}_${charge}', 'cout_total_charge_existe${index}_${charge}');" onclick="calculeChiffre('quantite_charge_existe${index}_${charge}', 'cout_unitaire_charge_existe${index}_${charge}', 'cout_total_charge_existe${index}_${charge}');" value="0"></td>
        <td><input type="text" min="0" id="cout_unitaire_charge_existe${index}_${charge}" class="form-control" name="cout_unitaire_charge_existe${index}[]" onkeyup="calculeChiffre('quantite_charge_existe${index}_${charge}', 'cout_unitaire_charge_existe${index}_${charge}', 'cout_total_charge_existe${index}_${charge}');" onclick="calculeChiffre('quantite_charge_existe${index}_${charge}', 'cout_unitaire_charge_existe${index}_${charge}', 'cout_total_charge_existe${index}_${charge}');" value="0"></td>
        <td><input type="text" id="cout_total_charge_existe${index}_${charge}" class="form-control" name="cout_total_charge_existe${index}[]" disabled></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle estimation
function addChargeAcquerirRow(index) {
    var tableBody = document.querySelector('#chargeAcquerirTable'+index+' tbody');
    var newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();
    var charge = $("#charge_acquerir"+index).val();
    $("#charge_acquerir"+index).val(parseInt(charge)+1);

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="designation_charge_acquerir${index}[]" placeholder="Désignation"></td>
        <td><input type="text" class="form-control" name="unite_charge_acquerir${index}[]" placeholder="Unité"></td>
        <td><input type="number" min="0" id="quantite_charge_acquerir${index}_${charge}" class="form-control" name="quantite_charge_acquerir${index}[]" onkeyup="calculeChiffre('quantite_charge_acquerir${index}_${charge}', 'cout_unitaire_charge_acquerir${index}_${charge}', 'cout_total_charge_acquerir${index}_${charge}');" onclick="calculeChiffre('quantite_charge_acquerir${index}_${charge}', 'cout_unitaire_charge_acquerir${index}_${charge}', 'cout_total_charge_acquerir${index}_${charge}');" value="0"></td>
        <td><input type="text" min="0" id="cout_unitaire_charge_acquerir${index}_${charge}" class="form-control" name="cout_unitaire_charge_acquerir${index}[]" onkeyup="calculeChiffre('quantite_charge_acquerir${index}_${charge}', 'cout_unitaire_charge_acquerir${index}_${charge}', 'cout_total_charge_acquerir${index}_${charge}');" onclick="calculeChiffre('quantite_charge_acquerir${index}_${charge}', 'cout_unitaire_charge_acquerir${index}_${charge}', 'cout_total_charge_acquerir${index}_${charge}');" value="0"></td>
        <td><input type="text" id="cout_total_charge_acquerir${index}_${charge}" class="form-control" name="cout_total_charge_acquerir${index}[]" disabled></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle banque
function addBanqueRow() {
    const tableBody = document.querySelector('#banqueTable tbody');
    const newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();
    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="nature_credit[]" placeholder="Nature du crédit"></td>
        <td><input type="text" class="form-control" name="nom_banque[]" placeholder="Nom de la banque"></td>
        <td><input type="date" class="form-control" name="date_debut[]"></td>
        <td><input type="text" min="0" class="form-control" name="montant_emp[]" placeholder="100000"></td>
        <td><input type="text" min="0" class="form-control" name="mensualite[]" placeholder="100000"></td>
        <td><input type="text" min="0" class="form-control" name="montant_restant[]" placeholder="100000"></td>
        <td><input type="date" class="form-control" name="date_echeance[]"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter un nouvel partenaire
function addPartenaireRow() {
    const tableBody = document.querySelector('#partenaireTable tbody');
    const newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="nom_partenaire[]" placeholder="Nom du partenaire"></td>
        <td><input type="text" class="form-control" name="montant_emprunte[]" placeholder="100000"></td>
        <td><input type="number" min="0" class="form-control" name="nombre_year_rem[]" placeholder="01"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter un nouvel equipement existant
function addEquipementExistRow() {
    const tableBody = document.querySelector('#equipementExistTable tbody');
    const newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="designation_equipement_exist[]" placeholder="Désignation"></td>
        <td><input type="text" class="form-control" name="unite_equipement_exist[]" placeholder="Forfait"></td>
        <td><input type="number" min="0" class="form-control" name="quantite_equipement_exist[]" placeholder="01"></td>
        <td><select class="form-select" id="etat_fonctionnement" name="etat_fonctionnement[]">
                                            <option value="">Selectionner l'état</option>
                                            <option value="neuf">Neuf</option>
                                            <option value="bon">Bon</option>
                                            <option value="moyen">Moyen</option>
                                            <option value="mauvais">Mauvais</option>
                                        </select></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter un nouvel equipement a acquerir
function addEquipementAqRow() {
    const tableBody = document.querySelector('#equipementAqTable tbody');
    const newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="designation_equipement_aq[]" placeholder="Désignation"></td>
        <td><input type="text" class="form-control" name="unite_equipement_aq[]" placeholder="Forfait"></td>
        <td><input type="number" min="0" class="form-control" name="quantite_equipement_aq[]" placeholder="01"></td>
        <td><input type="text" class="form-control" name="source_approvisionnement[]" placeholder="Source"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle structure financiere
function addStructureFinanciereRow() {
    const tableBody = document.querySelector('#structureFinanciereTable tbody');
    const newRow = document.createElement('tr');
    var trash_icon = $("#trash_icon").val();

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="designation_sf[]" placeholder="Désignation"></td>
        <td><input type="text" class="form-control" name="montant_sf[]" placeholder="100000"></td>
        <td><input type="text" class="form-control" name="apport_personnel[]" placeholder="100000"></td>
        <td><input type="text" min="0" class="form-control" name="subvention_sf[]" placeholder="100000"></td>
        <td><input type="text" min="0" class="form-control" name="emprunt_sf[]" placeholder="100000"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="${trash_icon}"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour supprimer une ligne
function removeRow(button) {
    var row = button.closest('tr');
    row.parentNode.removeChild(row);
}

// Fonction pour calculer le montant total
function calculeChiffre(quantite, prix_unitaire, chiffre_affaire){
    var quantity = $("#"+quantite).val().replace(/\s/g, '');
    var pu = $("#"+prix_unitaire).val().replace(/\s/g, '');
    var montant = parseFloat(quantity)*parseFloat(pu);
    if(parseInt(montant) > 0){
        $("#"+chiffre_affaire).val(montant);
    }else{
        $("#"+chiffre_affaire).val(0);
    }
}

function displayPartenaire(){
    var choice = $("#cible_partenaire option:selected").val();
    if(choice == 'oui'){
        document.getElementById('display_partenaire').style.display = 'initial';
    }else{
        document.getElementById('display_partenaire').style.display = 'none';
    }
}

/************ BEGIN SELECT CHARGEMENT SOUS TABLES **************************/
// Région
function changeValue(parent, child, table_item)
{
    var idparent_val = $("#"+parent).val();
    // alert(idparent_val);
    var table = table_item;

    var url = '/selection';

    $.ajax({
        url: url,
        type: 'GET',
        data: {idparent_val: idparent_val, table:table},
        dataType: 'json',
        error:function(data){alert("Erreur");},
        success: function (data) {
            var data = data.data;
            if(table == 'langue') {
                var content = '';
                for (var x = 0; x < data.length; x++) {
                    if(data[x]['id'] !='') {
                        content += '<div class="radio-custom radio-primary"><input type="radio" id="'+data[x]['id']+'" name="langue[]" value="'+data[x]['id']+'"><label class="no-fw" for="'+data[x]['id']+'">'+data[x]['name']+'</label></div>';
                    }
                }

                $('#'+child).html(content);

            }else{
                var options = '<option value="" selected>--- Choisir une valeur </option>';
                for (var x = 0; x < data.length; x++) {
                    if(data[x]['id'] !='') {
                        options += '<option value="' + data[x]['id'] + '">' + data[x]['name'] + '</option>';
                    }
                }
                $('#'+child).html(options);
            }

        }
    });
}
/************ END SELECT CHARGEMENT SOUS TABLES **************************/
