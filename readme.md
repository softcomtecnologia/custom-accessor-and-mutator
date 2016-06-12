#Custom Accessors and Mutators
># Accessors e Mutators Personalizados


The _CustomAccessorsAndMutators_ is a package to optimize the creation of accessor and mutator laravel. 
The focus is to set the accessors and mutators through an array informing the attribute as key and the method as value.

> A _CustomAccessorsAndMutators_ é um pacote para otimizar a criação de accessor e mutator laravel. 
> O foco é setar os accessors e mutators através de um array informando o atributo como chave e o metodo como valor. 

 
## Installation
>## Instalação


### Composer


If you already use Composer (which is highly recommended), add the dependency under the policy *"require"* your _composer.json_:


> Se você já utiliza o Composer (o que é extremamente recomendado), adicione a dependência abaixo à diretiva *"require"* do seu _composer.json_:

```php
    require : {
            "laravel/framework": "5.1.*",
            "igorwanbarros/custom-accessor-and-mutator": "master"
        }
```


## Usage
>## Uso


The package uses the trait _CustomAccessorsAndMutators_ to set the attributes, just add it in their class, as shown below:

> O pacote utiliza a trait _CustomAccessorsAndMutators_ para setar os atributos, para isso basta adiciona-la em suas classes, conforme mostrado abaixo:


```php
use Illuminate\Database\Eloquent\Model;
use Igorwanbarros\CustomAccessorAndMutator\CustomAccessorsAndMutators;

class Order extends Model
{
    use CustomAccessorsAndMutators;
    
    protected $table = 'order';
    
    protected $customAccessors = [
        //attribute name you model   => your default method for treating this type of data
        'you_attribute_name'         => '_yourMethodGet',
        'you_other_attribute_name'   => '_yourMethodGet',
    ];
    
    protected $customMutators = [
        'you_atribute_name'         => '_yourMethodGet',
        'you_other_atribute_name'   => '_yourMethodGet',
    ];
    
    
    protected function _youtMethodGet($value)
    {
        //you logic here
        return $value;
    }
    
    
    protected function _youtMethodSet($value)
    {
        //you logic here
        return $value;
    }
}
```


Or, in your Model class base:

> Ou, em sua class Model base:


```php
class ModelBase extends Model 
{
    use CustomAccessorsAndMutators
}
```


And in other models add only the fields and their respective methods:

> E nos demais models adicionar apenas os campos e seus respectivos métodos:


```php

class Order extends Model
{
    protected $table = 'order';
    
    protected $customAccessors = [
        'you_attribute_name'    => '_yourMethodGet',
    ];
    
    protected $customMutators = [
        'you_attribute_name'    => '_yourMethodGet',
    ];
    
    
    protected function _youtMethodGet($value)
    {
        //you logic here
        return $value;
    }
    
    
    protected function _youtMethodSet($value)
    {
        //you logic here
        return $value;
    }
}
```


### Adding via Class
>### Adicionando via Class

You can also implement the FormatAccessorsAndMutator class to define your formatting logic (for certain types of data for example) and tells you there as shown below:

> Você pode também implementar a classe _FormatAccessorsAndMutator_ para definir sua lógica de formatação 
> (para determinados tipos de dados por exemplo) e informa-lá conforme é mostrado abaixo:


```php
namespace App\FormatAccessorsAndMutators;

use Igorwanbarros\CustomAccessorAndMutator\FormatAccessorAndMutator;

class MoneyFormatAccessorsAndMutators implements FormatAccessorAndMutator
{
    public static function get($value)
    {
        //you logic here
        return $value;
    }
    
    
    public static function set($value)
    {
        //you logic here
        return $value;
    }
}
```


Already in its Model class you can set as follows:

> Já em sua classe Model você pode definir da seguinte forma:


```php
use Illuminate\Database\Eloquent\Model;
use Igorwanbarros\CustomAccessorAndMutator\CustomAccessorsAndMutators;
use App\FormatAccessorsAndMutators\MoneyFormatAccessorsAndMutators;

class Order extends Model
{
    use CustomAccessorsAndMutators;
    
    protected $table = 'order';
    
    protected $customAccessors = [
        'you_attribute_name'         => MoneyFormatAccessorsAndMutators::class,
        'you_other_attribute_name'   => MoneyFormatAccessorsAndMutators::class,
    ];
    
    protected $customMutators = [
        'you_atribute_name'         => MoneyFormatAccessorsAndMutators::class,
        'you_other_atribute_name'   => MoneyFormatAccessorsAndMutators::class,
    ];
    
}
```


## Licence

MIT Licence