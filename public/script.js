// Ajouter une nouvelle ligne d'activité
function addStepRow() {

    const table = document.getElementById("activities-table");
    const rowCount = table.rows.length + 1;
    const newRow = `
        <tr>
            <th scope="row">${rowCount}</th>
            <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité"></td>
            <td><input type="date" name="dates_indicatives[]" class="form-control"></td>
        </tr>`;

    table.insertAdjacentHTML("beforeend", newRow);
}

// Ajouter un nouveau promoteur
function addPromoteurRow(){
    $.ajax({
        type:'get',
        url:"/add/promoteur",
        dataType:'html',
        error:function(){ alert("Erreur");},
        success:function(response){
            const promoteur = document.getElementById("promoteurs");
            promoteur.insertAdjacentHTML("beforeend", response);
        }
    });
}

// Fonction pour ajouter un nouveau employe
function addEmployeRow() {
    var tableBody = document.querySelector('#personnelTable tbody');
    var newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="poste[]" placeholder="Poste"></td>
        <td><input type="text" class="form-control" name="qualification[]" placeholder="Qualification"></td>
        <td><input type="number" class="form-control" name="effectif[]" placeholder="Effectif"></td>
        <td><input type="number" class="form-control" name="salaire[]" placeholder="Salaires mensuels"></td>
        <td><input type="text" class="form-control" name="taches[]" placeholder="Tâches prévues"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle estimation
function addEstimationRow() {
    var tableBody = document.querySelector('#estimationTable tbody');
    var newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="designation[]" placeholder="Désignation"></td>
        <td><input type="text" class="form-control" name="unite[]" placeholder="Unité"></td>
        <td><input type="number" class="form-control" name="quantite[]" placeholder="Quantité"></td>
        <td><input type="number" class="form-control" name="prix_unitaire[]" placeholder="PU"></td>
        <td><input type="text" class="form-control" name="montant[]" disabled value="0"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour ajouter une nouvelle estimation de la première année
function addEstimationFirstRow() {
    var tableBody = document.querySelector('#estimationFirstTable tbody');
    var newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td><input type="text" class="form-control" name="produit[]" placeholder="Produit"></td>
        <td><input type="number" class="form-control" name="quantite_first[]" placeholder="Quantité"></td>
        <td><input type="number" class="form-control" name="capacite_accueil[]" placeholder="Capacité d'accueil"></td>
        <td><input type="number" class="form-control" name="taux_occupation[]" placeholder="0.0%"></td>
        <td><input type="number" class="form-control" name="prix_unitaire_first[]" placeholder="PU"></td>
        <td><input type="number" class="form-control" name="ca_mensuel[]" placeholder="CA mensuel"></td>
        <td><input type="number" class="form-control" name="ca_annuel[]" placeholder="CA annuel"></td>
        <td><button type="button" class="btn btn-danger btn-sm btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
    `;

    tableBody.appendChild(newRow);
}

// Fonction pour supprimer une ligne
function removeRow(button) {
    var row = button.closest('tr');
    row.parentNode.removeChild(row);
}