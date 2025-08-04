<div class="tabs">
  <ul>
    <li><a href="#tab1">1. Informations Générales</a></li>
    <li><a href="#tab2">2. Situation de Référence</a></li>
    <li><a href="#tab3">3. Projet de Développement</a></li>
    <li><a href="#tab4">4. Étude Commerciale</a></li>
    <li><a href="#tab5">5. Étude Technique</a></li>
    <li><a href="#tab6">6. Dossier Financier</a></li>
    <li><a href="#tab7">7. Analyse de la Rentabilité</a></li>
    <li><a href="#tab8">8. Analyse Socio-économique</a></li>
  </ul>

  <div id="tab1" class="card">
    <h2>Informations Générales</h2>
    <label>Entreprise :</label><input type="text" name="entreprise"><br>
    <label>11 BP :</label><input type="text" name="bp"><br>
    <label>Téléphone :</label><input type="text" name="telephone"><br>
    <label>Email :</label><input type="email" name="email"><br>
    <label>Titre du projet :</label><input type="text" name="titre_projet"><br>
    <label>Partenaires techniques :</label><textarea name="partenaires"></textarea><br>
    <label>Avril 2021</label>
    <h3>Tableau synthétique du projet</h3>
    <label>Principaux produits à offrir :</label><textarea name="produits"></textarea><br>
    <label>Activités :</label><textarea name="activites"></textarea><br>
    <label>Nom et adresse de l’entreprise :</label><textarea name="adresse_entreprise"></textarea><br>
    <label>Atouts du promoteur et de l’entreprise :</label><textarea name="atouts"></textarea><br>
    <label>Caractère innovant du projet :</label><textarea name="innovant"></textarea><br>

    <h4>Indicateurs-clés du projet</h4>
    <label>Coût total du projet :</label><input type="text" name="cout_total"> FCFA<br>
    <label>Apport Personnel :</label><input type="text" name="apport"> FCFA<br>
    <label>Crédit sollicité :</label><input type="text" name="credit"> FCFA<br>
    <label>Chiffre d’affaires moyen/an :</label><input type="text" name="ca_moyen"> FCFA<br>
    <label>Résultat net moyen :</label><input type="text" name="resultat_net"> FCFA<br>
    <label>TRI :</label><input type="text" name="tri"> %<br>
    <label>Indice de profitabilité :</label><input type="text" name="ip"> <br>
    <label>Délais de récupération :</label><input type="text" name="delai"> <br>
    <label>Valeur actuelle nette :</label><input type="text" name="van"> FCFA<br>
    <label>Emplois nouveaux :</label><input type="number" name="emplois_nouveaux"><br>
    <label>Emplois consolidés :</label><input type="number" name="emplois_consolides"><br>
  </div>

  <div id="tab2" class="card">
    <h2>Situation de Référence</h2>
    <h3>Présentation de l’entreprise et du responsable</h3>
    <label>Présentation de l’entreprise :</label><textarea name="presentation_entreprise"></textarea><br>
    <label>Présentation du responsable :</label><textarea name="presentation_responsable"></textarea><br>
    <label>Statut juridique et gérance :</label><input type="text" name="statut"><br>

    <h3>Situation financière</h3>
    <h4>Tableau 1 : Compte d’exploitation</h4>
    <table>
      <tr><th>DESIGNATION</th><th>2015</th><th>2016</th><th>2017</th></tr>
      <tr><td>Chiffre d’affaires</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Valeur ajoutée</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Résultat net</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Capacité d'autofinancement</td><td><input></td><td><input></td><td><input></td></tr>
    </table>

    <h4>Tableau 2 : Bilan en grandes masses</h4>
    <table>
      <tr><th>ACTIF</th><th>2015</th><th>2016</th><th>2017</th></tr>
      <tr><td>Actif immobilisé</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Actif circulant</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Trésorerie actif</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td><strong>Total général</strong></td><td><input></td><td><input></td><td><input></td></tr>
      <tr><th>PASSIF</th><th>2015</th><th>2016</th><th>2017</th></tr>
      <tr><td>Capitaux propres</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Dettes à long et moyen terme</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Passif circulant</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>Trésorerie passif</td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td><strong>Total général</strong></td><td><input></td><td><input></td><td><input></td></tr>
    </table>

    <h4>Relations bancaires</h4>
    <table>
      <tr><th>#</th><th>Nature du crédit</th><th>Structure</th><th>Début</th><th>Montant</th><th>Mensualité</th><th>Reste</th><th>Échéance</th></tr>
      <tr><td>1</td><td><input></td><td><input></td><td><input type="date"></td><td><input></td><td><input></td><td><input></td><td><input type="date"></td></tr>
      <tr><td>2</td><td><input></td><td><input></td><td><input type="date"></td><td><input></td><td><input></td><td><input></td><td><input type="date"></td></tr>
      <tr><td>3</td><td><input></td><td><input></td><td><input type="date"></td><td><input></td><td><input></td><td><input></td><td><input type="date"></td></tr>
    </table>
  </div>

  <div id="tab3" class="card">
    <h2>Projet de Développement</h2>
    <label>Idée du projet :</label><textarea name="idee_projet"></textarea><br>
    <label>Objectif du projet :</label><textarea name="objectif_projet"></textarea><br>

    <h3>Calendrier de réalisation</h3>
    <table>
      <tr><th>Activités</th><th>Période</th></tr>
      <tr><td><input></td><td><input></td></tr>
      <tr><td><input></td><td><input></td></tr>
    </table>
  </div>

  <div id="tab4" class="card">
    <h2>Étude Commerciale</h2>
    <h3>Produits ou services offerts</h3>
    <label>Produit 1 :</label><textarea name="produit1"></textarea><br>
    <label>Produit 2 :</label><textarea name="produit2"></textarea><br>

    <h3>Étude de marché</h3>
    <label>Étude de l'offre :</label><textarea name="offre"></textarea><br>
    <label>Étude de la demande :</label><textarea name="demande"></textarea><br>

    <h3>Chiffre d'affaires prévisionnel</h3>
    <table>
      <tr><th>Produit/Service</th><th>Unité</th><th>Quantité</th><th>Prix unitaire</th><th>CA</th></tr>
      <tr><td><input></td><td><input></td><td><input></td><td><input></td><td><input></td></tr>
    </table>
  </div>

  <div id="tab5" class="card">
    <h2>Étude Technique</h2>
    <h3>Infrastructures et équipements</h3>
    <label>Description :</label><textarea name="infra"></textarea><br>
    <h4>Équipement existant</h4>
    <table>
      <tr><th>Description</th><th>Unité</th><th>Quantité</th><th>État</th></tr>
      <tr><td><input></td><td><input></td><td><input></td><td><input></td></tr>
    </table>
  </div>

  <div id="tab6" class="card">
    <h2>Dossier Financier</h2>
    <h3>Coût total du projet</h3>
    <table>
      <tr><th>Désignation</th><th>Existant</th><th>À acquérir</th></tr>
      <tr><td><input></td><td><input></td><td><input></td></tr>
    </table>
  </div>

  <div id="tab7" class="card">
    <h2>Analyse de la Rentabilité</h2>
    <h3>Valeur Actuelle Nette</h3>
    <table>
      <tr><th>Année</th><th>CAF</th><th>Variation BFR</th><th>Investissements</th><th>Flux net</th></tr>
      <tr><td>Année 1</td><td><input></td><td><input></td><td><input></td><td><input></td></tr>
    </table>
  </div>

  <div id="tab8" class="card">
    <h2>Analyse Socio-économique</h2>
    <h3>Répartition de la Valeur Ajoutée</h3>
    <table>
      <tr><th>Rubriques</th><th>Année 1</th><th>Année 2</th><th>Total</th><th>%</th></tr>
      <tr><td>Personnel</td><td><input></td><td><input></td><td><input></td><td><input></td></tr>
      <tr><td>État</td><td><input></td><td><input></td><td><input></td><td><input></td></tr>
    </table>
  </div>
</div>
