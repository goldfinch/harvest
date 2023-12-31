field -- scaffoldFormField
remove -- removeByName
fields(['TabName' => [...Fields]]) -- addFieldsToTab
dataField -- dataFieldByName

removeAll -- *removeByName /// remove all fields
removeAllCurrent -- *removeByName /// remove all fields based on the current object/page
removeAllInTab -- *removeByName /// remove all fields in tab
require([...FieldsNames]) -- setRequireFields /// 
addError -- * /// adds custom error


<!-- Internal general fields -->

| Method            | Class                  | Attributes                                                                                       | Description    |
|-------------------|------------------------|--------------------------------------------------------------------------------------------------|----------------|
| checkbox          | CheckboxField          | $name, $title = null, $value = null                                                              | Checkbox field |
| dropdown          | DropdownField          | $name, $title = null, $source = [], $value = null                                                |                |
| readonly          | ReadonlyField          | $name, $title = null, $value = null                                                              |                |
| text              | TextareaField          | $name, $title = null, $value = null                                                              |                |
| string            | TextField              | $name, $title = null, $value = '', $maxLength = null, $form = null                               |                |
| password          | PasswordField          | $name, $title = null, $value = ''                                                                |                |
| action            | FormAction             | $action, $title = '', $form = null                                                               |                |
| passwordConfirmed | ConfirmedPasswordField | $name, $title = null, $value = '', $form = null, $showOnClick = false, $titleConfirmField = null |                |
| currency          | CurrencyField          | $name, $title = null, $value = '', $maxLength = null, $form = null                               |                |
| date              | DateField              | $name, $title = null, $value = '', $maxLength = null, $form = null                               |                |
| datetime          | DatetimeField          | $name, $title = null, $value = '', $maxLength = null, $form = null                               |                |
| email             | EmailField             | $name, $title = null, $value = '', $maxLength = null, $form = null                               |                |
|                   |                        |                                                                                                  |                |
|                   |                        |                                                                                                  |                |

harvest gets involved only if harvest() or harvestSettings() presented

for getCMSFields

```
public function harvest(Harvest $harvest)
{
    $harvest->remove('Content');
    // $harvest->removeAll();
    // $harvest->removeAllCurrent();
    // $harvest->addError('Error message');
    $harvest->require([
        'Color',
        'Varchar',
        'Icon',
    ]);

    $harvest->fields([
        'Root.Main' => [
            $harvest->colorPicker('Color'),
            $harvest->string('Varchar'),
        ],
        'Root.Demo' => [
            $harvest->iconFile('Icon'),
        ],
    ]);
}
```

for getSettingsFields (SiteTree only)

```
public function harvestSettings(Harvest $harvest)
{
    $harvest->remove('ShowInMenus');

    $harvest->require([
        'ShowInFooter'
    ]);

    // $harvest->getFields();
}
```

(optional) - fields could be extended by other external modules which sometimes lead to a missmatch due to sequence. To make sure harvest() and harvestSettings() receved latest $fields, apply trait to the class

```
use Goldfinch\Harvest\Traits\HarvestTrait;

class Page {
  
  use HarvestTrait;

  ...
}
```

available extends

```
public function updateHarvest(Harvest $harvest)
{
    // ..
}
public function updateHarvestSettings(Harvest $harvest)
{
    // ..
}
public function updateHarvestCompositeValidator(Harvest $harvest)
{
    // ..
}
public function updateHarvestValidate(Harvest $harvest)
{
    // ..
}
```

has_one | belongs_to

```
dropdown
groupedDropdown
radio
dropdownTree
objectLink
object
autocomplete
// - selectionGroup
```

has_many | many_many | belongs_many_many

```
checkboxSet
listbox
checkboxSet
tag
```

many_many | belongs_many_many

```
multiSelect
```

links

```
link
linkSS
inlineLink
inlineLinks
```
