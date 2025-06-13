  @extends('layouts.app')

      @section('content')
      <span id="creer-evenement">

          <div class="form-container">
              <h2 class="event-title">Modifier un événement</h2>
              <form action="{{route('evenement.doModifier', $evenement->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                      <label for="nom">Nom de l'événement</label>
                      <input type="text" id="nom" name="nom" required maxlength="255" value="{{ $evenement->nom ?? old('nom') }}" placeholder="ex: 'Concert de Jazz', 'Conférence sur l'IA'...">
                      @error('nom')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="diffusion">Diffusion de l'événement</label>
                      <select id="diffusion" name="diffusion" required>
                          <option value="1" {{ $evenement->diffusion == '1' ? 'selected' : '' }}>Public</option>
                          <option value="2" {{ $evenement->diffusion == '2' ? 'selected' : '' }}>Privé</option>
                          <option value="3" {{ $evenement->diffusion == '3' ? 'selected' : '' }}>Communautaire</option>
                      </select>
                      @error('diffusion')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="categories">Créateurs</label>
                      <!-- Container principal -->
                        <div class="categories-container">
                            <!-- Conteneur combiné pour la barre de recherche et la liste -->
                            <div class="categories-wrapper">
                                <!-- Barre de recherche intégrée -->
                                <div class="search-container">
                                    <input type="text" id="searchInput2" class="form-control" placeholder="Rechercher des utilisateurs...">
                                </div>
                                
                                <!-- Liste de checkboxes -->
                                <div class="checkbox-list">
                                    @foreach ($editeurs as $editeur)
                                    <div class="checkbox-item">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="editeurs_{{$editeur->id}}" name="editeur[]" value="{{$editeur->id}}" checked >
                                            <span class="checkbox-text">{{$editeur->name}}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                    @foreach($users as $user)
                                    <div class="checkbox-item">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="editeurs_{{$user->id}}" name="editeur[]" value="{{$user->id}}" {{ is_array(old('user')) && in_array($user->id, old('user')) ? 'checked' : '' }}>
                                            <span class="checkbox-text">{{$user->name}}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('categorie')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                  </div>

                  <div class="form-group">
                      <label for="categories">Catégories</label>
                      <!-- Container principal -->
                        <div class="categories-container">
                            <!-- Conteneur combiné pour la barre de recherche et la liste -->
                            <div class="categories-wrapper">
                                <!-- Barre de recherche intégrée -->
                                <div class="search-container">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher des catégories...">
                                </div>
                                
                                <!-- Liste de checkboxes -->
                                <div class="checkbox-list">
                                    @foreach ($evenementCategories as $categorie)
                                    <div class="checkbox-item">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="categorie_{{$categorie->id}}" name="categorie[]" value="{{$categorie->id}}" checked>
                                            <span class="checkbox-text">{{$categorie->libelle}}</span>
                                        </label>
                                    @endforeach
                                    @foreach(\App\Models\Categorie::whereNotIn('id', $evenementCategories->pluck('id'))->get() as $categorie)
                                    <div class="checkbox-item">
                                        <label class="checkbox-label">
                                            <input type="checkbox" id="categorie_{{$categorie->id}}" name="categorie[]" value="{{$categorie->id}}" {{ is_array(old('categorie')) && in_array($categorie->id, old('categorie')) ? 'checked' : '' }}>
                                            <span class="checkbox-text">{{$categorie->libelle}}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('categorie')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                  </div>

                  <div class="form-group">
                      <label for="num_rue">Numéro de rue (facultatif)</label>
                      <input type="text" id="num_rue" name="num_rue" maxlength="10" value="{{ $evenement->num_rue ?? old('num_rue') }}" placeholder="ex: '12', 'A'... ">
                      @error('num_rue')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="allee">Rue / Boulevard / Place / Lieu</label>
                      <input type="text" id="allee" name="allee" maxlength="255" value="{{ $evenement->allee ?? old('allee') }}" placeholder="ex: 'Rue de la Paix', 'Hotel de ville'... ">
                      @error('allee')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="ville">Ville</label>
                      <input type="text" id="ville" name="ville" required maxlength="255" value="{{ $evenement->ville ?? old('ville') }}">
                      @error('ville')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="code_postal">Code postal</label>
                      <input type="number" id="code_postal" name="code_postal" required maxlength="5" minlength="5" value="{{ $evenement->code_postal ?? old('code_postal') }}">
                      @error('code_postal')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="pays">Pays</label>
                      <input type="text" id="pays" name="pays" value="{{  $evenement->pays ?? old('pays', 'France') }}" maxlength="255">
                      @error('pays')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="date">Date</label>
                      <input type="date" id="date" name="date" required value="{{ $evenement->date ? \Carbon\Carbon::parse($evenement->date)->format('Y-m-d') : old('date') }}">
                      @error('date')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="heure">Heure</label>
                      <input type="time" id="heure" name="heure" required value="{{ $evenement->heure ?? old('heure') }}">
                      @error('heure')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="max_participants">Nombre maximum de participants</label>
                      <input type="number" id="max_participants" name="max_participants" min="1" placeholder="Illimité" value="{{ $evenement->max_participants ?? old('max_participants') }}">
                      @error('max_participants')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="description">Description</label>
                      <textarea id="description" name="description" required>{{$evenement->description ?? old('description') }}</textarea>
                      @error('description')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="image">Image de l'événement</label>
                      <div class="custom-file-input">
                          <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(this)">
                          <span class="file-label">Choisir une image</span>
                      </div>
                      <div class="image-preview" id="imagePreview">
                          Aperçu de l'image
                      </div>
                      @error('image')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label class="annonciateur-label">
                          <input type="checkbox" id="annonciateur" name="annonciateur" value="1" {{ $evenement->annonciateur ?? old('annonciateur') ? 'checked' : '' }}>
                          <span class="checkbox-text">Je ne suis qu'annonciateur</span>
                      </label>
                      @error('annonciateur')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="button-group">
                      <button type="submit">Sauvegarder l'événement</button>
                      <a href="{{route('accueil')}}"><button type="button" class="back-button">Retour</button></a>
                  </div>
              </form>
          </div>

          <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                let searchText = this.value.toLowerCase();
                let checkboxItems = document.querySelectorAll('.checkbox-item');
                
                checkboxItems.forEach(item => {
                    let label = item.querySelector('label').textContent.toLowerCase();
                    if (label.includes(searchText)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            document.getElementById('searchInput2').addEventListener('keyup', function() {
                let searchText = this.value.toLowerCase();
                let checkboxItems = document.querySelectorAll('.checkbox-item');
                
                checkboxItems.forEach(item => {
                    let label = item.querySelector('label').textContent.toLowerCase();
                    if (label.includes(searchText)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
            
          function previewImage(input) {
              const preview = document.getElementById('imagePreview');
              const fileLabel = input.parentElement.querySelector('.file-label');
          
              if (input.files && input.files[0]) {
                  const reader = new FileReader();
              
                  reader.onload = function(e) {
                      preview.style.backgroundImage = `url('${e.target.result}')`;
                      preview.textContent = '';
                      fileLabel.textContent = input.files[0].name;
                  }
              
                  reader.readAsDataURL(input.files[0]);
              } else {
                  preview.style.backgroundImage = 'none';
                  preview.textContent = 'Aperçu de l\'image';
                  fileLabel.textContent = 'Choisir une image';
              }
          }
      </script>
      </span>
      @endsection