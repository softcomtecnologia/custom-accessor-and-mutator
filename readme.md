#Custom Accessors and Mutators
The _CustomAccessorsAndMutators_ is a package to optimize the creation of accessor and mutator laravel. 
The focus is to set the accessors and mutators through an array informing the attribute as key and the method as value.

> A _CustomAccessorsAndMutators_ é um pacote para otimizar a criação de accessor e mutator laravel. 
> O foco é setar os accessors e mutators através de um array informando o atributo como chave e o metodo como valor. 

 
## Installation

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
        //you key       => your default method for treating this type of data
        'unit_price'    => '_yourMethodGetNumber',
        'total_price'   => '_yourMethodGetNumber',
    ];
    
    protected $customMutators = [
        'unit_price'    => '_yourMethodGetNumber',
        'total_price'   => '_yourMethodGetNumber',
    ];
    
    
    protected function _youtMethodGetNumber($value)
    {
        //you logic here
        return $value;
    }
    
    
    protected function _youtMethodSetNumber($value)
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
        'unit_price'    => '_yourMethodGetNumber',
    ];
    
    protected $customMutators = [
        'unit_price'    => '_yourMethodGetNumber',
    ];
    
    
    protected function _youtMethodGetNumber($value)
    {
        //you logic here
        return $value;
    }
    
    
    protected function _youtMethodSetNumber($value)
    {
        //you logic here
        return $value;
    }
}
```

## Licence
MIT Licence