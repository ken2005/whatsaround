  @extends('layouts.app')

      @section('content')
          <div class="form-container">
              <h2 style="margin-bottom: 1.5rem; color: #2c3e50;">Créer un événement</h2>
              <form action="{{route('doCreer')}}" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                      <label for="nom">Nom de l'événement</label>
                      <input type="text" id="nom" name="nom" required maxlength="255" value="{{ old('nom') }}">
                      @error('nom')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="diffusion">Diffusion de l'événement</label>
                      <select id="diffusion" name="diffusion" required>
                          <option value="1" {{ old('diffusion') == '1' ? 'selected' : '' }}>Public</option>
                          <option value="2" {{ old('diffusion') == '2' ? 'selected' : '' }}>Privé</option>
                          <option value="3" {{ old('diffusion') == '3' ? 'selected' : '' }}>Communautaire</option>
                      </select>
                      @error('diffusion')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="categories">Catégories</label>
                      <!-- Container principal -->
                        <div style="width: 300px;">
                            <!-- Conteneur combiné pour la barre de recherche et la liste -->
                            <div style="border: 1px solid #ccc; border-radius: 4px;">
                                <!-- Barre de recherche intégrée -->
                                <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher des catégories...">
                                </div>
                                
                                <!-- Liste de checkboxes -->
                                <div class="checkbox-list" style="height: 200px; overflow-y: auto; padding: 8px;">
                                    @foreach(\App\Models\Categorie::all() as $categorie)
                                    <div class="checkbox-item">
                                        <label style="display: flex; align-items: center;">
                                            <input type="checkbox" id="categorie_{{$categorie->id}}" name="categorie[]" value="{{$categorie->id}}" {{ is_array(old('categorie')) && in_array($categorie->id, old('categorie')) ? 'checked' : '' }}>
                                            <span style="margin-left: 8px;">{{$categorie->libelle}}</span>
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
                      <input type="text" id="num_rue" name="num_rue" maxlength="10" value="{{ old('num_rue') }}">
                      @error('num_rue')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="allee">Rue / Boulevard / Place / Lieu</label>
                      <input type="text" id="allee" name="allee" maxlength="255" value="{{ old('allee') }}" placeholder="ex: 'Rue de la Paix', 'Hotel de ville'... ">
                      @error('allee')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="ville">Ville</label>
                      <input type="text" id="ville" name="ville" required maxlength="255" value="{{ old('ville') }}">
                      @error('ville')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="code_postal">Code postal</label>
                      <input type="number" id="code_postal" name="code_postal" required maxlength="5" minlength="5" value="{{ old('code_postal') }}">
                      @error('code_postal')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="pays">Pays</label>
                      <input type="text" id="pays" name="pays" value="{{ old('pays', 'France') }}" maxlength="255">
                      @error('pays')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="date">Date</label>
                      <input type="date" id="date" name="date" required value="{{ old('date') }}">
                      @error('date')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="heure">Heure</label>
                      <input type="time" id="heure" name="heure" required value="{{ old('heure') }}">
                      @error('heure')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="max_participants">Nombre maximum de participants</label>
                      <input type="number" id="max_participants" name="max_participants" min="1" placeholder="Illimité" value="{{ old('max_participants') }}">
                      @error('max_participants')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="form-group">
                      <label for="description">Description</label>
                      <textarea id="description" name="description" required>{{ old('description') }}</textarea>
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
                      <label style="display: flex; align-items: center;">
                          <input type="checkbox" id="annonciateur" name="annonciateur" value="1" {{ old('annonciateur') ? 'checked' : '' }}>
                          <span style="margin-left: 8px;">Je ne suis qu'annonciateur</span>
                      </label>
                      @error('annonciateur')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="button-group">
                      <button type="submit">Créer l'événement</button>
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
                        </script>

                        <style>
                        .form-control {
                            padding: 8px;
                            border: none;
                            width: 100%;
                            outline: none;
                        }

                        .checkbox-item {
                            padding: 4px 0;
                        }

                        .checkbox-item label {
                            margin-left: 0;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                        }

                        .checkbox-item input[type="checkbox"] {
                            cursor: pointer;
                            margin: 0;
                        }

                        .text-danger {
                            color: #dc3545;
                            font-size: 0.875rem;
                            margin-top: 0.25rem;
                        }
                        </style>
      <style>
          .form-container {
              max-width: 800px;
              margin: 2rem auto;
              padding: 2rem;
              background-color: white;
              border-radius: 8px;
              box-shadow: 0 2px 4px rgba(0,0,0,0.1);
          }

          .form-group {
              margin-bottom: 1.5rem;
          }

          label {
              display: block;
              margin-bottom: 0.5rem;
              color: #2c3e50;
              font-weight: bold;
          }

          input[type="text"],
          input[type="date"],
          input[type="time"],
          input[type="number"],
          textarea,
          select {
              width: 100%;
              padding: 0.8rem;
              border: 1px solid #ddd;
              border-radius: 4px;
              font-size: 1rem;
          }

          select[multiple] {
              height: 150px;
          }

          textarea {
              height: 150px;
              resize: vertical;
          }

          .custom-file-input {
              position: relative;
              display: inline-block;
              width: 100%;
          }

          .custom-file-input input[type="file"] {
              position: absolute;
              left: 0;
              top: 0;
              opacity: 0;
              width: 100%;
              height: 100%;
              cursor: pointer;
          }

          .custom-file-input .file-label {
              display: block;
              padding: 0.8rem;
              background-color: #f8f9fa;
              border: 1px solid #ddd;
              border-radius: 4px;
              text-align: center;
              color: #2c3e50;
              transition: all 0.3s ease;
          }

          .custom-file-input:hover .file-label {
              background-color: #e9ecef;
              border-color: #2c3e50;
          }

          .image-preview {
              width: 100%;
              height: 200px;
              border: 2px dashed #ddd;
              border-radius: 4px;
              margin-top: 0.5rem;
              display: flex;
              align-items: center;
              justify-content: center;
              color: #666;
              background-size: contain;
              background-repeat: no-repeat;
              background-position: center;
          }

          .button-group {
              display: flex;
              gap: 1rem;
          }

          .button-group button {
              padding: 0.5rem 1rem;
              border-radius: 4px;
              cursor: pointer;
          }

          .back-button {
              background-color: #2c3e50;
              color: white;
              border: none;
          }

          .back-button:hover {
              background-color: #34495e;
          }
      </style>

      <script>
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
      @endsection