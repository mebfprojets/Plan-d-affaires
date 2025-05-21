<div class="promo mt-3">
    <div class="row mb-3">
        <label for="age" class="col-lg-3 col-form-label">Âge</label>
        <div class="col-lg-8">
            <input type="number" class="form-control" id="age" name="age[]" placeholder="Entrez votre âge">
        </div>
    </div>

    <div class="row mb-3">
        <label for="sexe" class="col-lg-3 col-form-label">Sexe</label>
        <div class="col-lg-8">
            <select class="form-select" id="sexe" name="sexe[]">
                <option value="">Selectionner le sexe...</option>
                @foreach($sexes as $sexe)
                <option value="{{ $sexe->id }}">{{ $sexe->libelle }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label for="situation" class="col-lg-3 col-form-label">Situation de famille</label>
        <div class="col-lg-8">
            <select class="form-select" id="situation_famille" name="situation_famille[]">
                <option value="">Selectionner la situation ...</option>
                @foreach($situation_familles as $situation_famille)
                <option value="{{ $situation_famille->id }}">{{ $situation_famille->libelle }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label for="domicile" class="col-lg-3 col-form-label">Domicile</label>
        <div class="col-lg-8">
            <input type="text" class="form-control" id="domicile" name="domicile[]" placeholder="Lieu de domicile">
        </div>
    </div>

    <div class="row mb-3">
        <label for="adresse" class="col-lg-3 col-form-label">Adresse</label>
        <div class="col-lg-8">
            <input type="text" class="form-control" id="adresse" name="adresse[]" placeholder="Adresse complète">
        </div>
    </div>
    <div class="row mb-3">
        <label for="niveau_formation" class="col-lg-3 col-form-label">Niveau de formation</label>
        <div class="col-lg-8">
            <input type="text" class="form-control" id="niveau_formation" name="niveau_formation[]" placeholder="Niveau formation">
        </div>
    </div>
    <div class="row mb-3">
        <label for="experience_secteur_activite" class="col-lg-3 col-form-label">Expérience dans le secteur d’activités </label>
        <div class="col-lg-8">
            <input type="text" class="form-control" id="experience_secteur_activite" name="experience_secteur_activite[]" placeholder="Expérience secteur activité">
        </div>
    </div>
    <div class="row mb-3">
        <label for="activite_actuelle" class="col-lg-3 col-form-label">Activité actuelle</label>
        <div class="col-lg-8">
            <input type="text" class="form-control" id="activite_actuelle" name="activite_actuelle[]" placeholder="Activité actuelle">
        </div>
    </div>
    <div class="row mb-3">
        <label for="motivation_creation" class="col-lg-3 col-form-label">Motivation pour la création</label>
        <div class="col-lg-8">
            <input type="text" class="form-control" id="motivation_creation" name="motivation_creation[]" placeholder="Motivation pour la création">
        </div>
    </div>
    <div class="row mb-3">
        <label for="garantie_aval" class="col-lg-3 col-form-label">Garantie, aval ou caution à présenter</label>
        <div class="col-lg-8">
            <input type="text" class="form-control" id="garantie_aval" name="garantie_aval[]" placeholder="Garantie, aval ou caution à présenter">
        </div>
    </div>
</div>
