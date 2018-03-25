# crud-rails

##Instalação
Para instalar esse pacote, é necessário executar os seguintes comandos:
```
composer require raphaelvilela/crud-rails
php artisan vendor:publish
```

##Utilização
Para a criação de um CRUD é necessário seguir os seguintes passos:

###Passo 01 - Crie seu modelo
Sugerimos que você crie seu modelo a partir do comando abaixo, pois assim já será criado o migration e o controller

```
php artisan make:model NomeDoModelo -mc
```

Altere o migration de forma coerente com os campos de seu interesse e execute o migration em seu banco de dados.

###Passo 02 - Configure o Model
Adicione ao seu modelo as variáveis abaixo para que este possa validar as requisições realizadas.

```
protected $guarded = [];
public $rules = [
    'field_name_01' => 'required',
    'field_name_02' => 'required',
    'field_name_03' => 'required',
    'field_name_04' => 'required',
    'field_name_05' => 'required'
];
```

###Passo 04 - Configure o Controller
Deve-se alterar o Controller criado para que ele extenda ModelController. Ele também deve informar a qual Model este controller se refere.

```
class NomeDoModelController extends ProductSiteModelController
{
    public function __construct()
    {
        parent::__construct(NomeDoModel::class);
    }

```

###Passo 03 - Construa as views do CRUD
Para cada CRUD é necessário criar uma pasta contendo duas view: A primeira que lista os registros e a segunda que crie um formulário para cadastro e alteração de registros.


``` 
nome_do_model/index.blade.php

    @extends('crud-rails::forms.list')
    @section('list-table')
        {{$paginate_models->links()}}
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            <th>Ações</th>
            </thead>
            @foreach($paginate_models as $model)
                <tr>
                    <td>{{$model->name}}</td>
                    <td>
                        <a class="btn btn-success btn-sm" href="{{route($model_code . '.edit', ['id' => $model->id])}}">
                            <i class="fa fa-edit"></i> <span class="hidden-xs">Editar</span>
                        </a>
                        <form class="d-inline-block"
                              method="post"
                              action="{{route($model_code . '.destroy',['id'=>$model->id])}}">
                            <input type="hidden" name="_method" value="DELETE"/>
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
    
        </table>
        {{$paginate_models->links()}}
    @endsection
```

``` 
nome_do_model/index.blade.php

    @extends('crud-rails::forms.form')
    @section('fields')
        @include("crud-rails::forms.components.inputText", ['name' => 'name'])
        @include("crud-rails::forms.components.submit",    ['name' => 'save'])
    @endsection
```



###Passo 04 - Adicione a rota
Basta adicionar a rota abaixo no arquivo routes/web.php e você já terá um CRUD completo.

``` 
    Route::resource('nome_do_model', 'NomeDoModelController');
```