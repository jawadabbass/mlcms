<?php

namespace App\Http\Controllers\Back;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\ModuleCodeGeneratorBackFormRequest;
use Illuminate\Support\Facades\Redirect;

class ModuleCodeGeneratorController extends Controller
{
    private $stubArray = [
        'MODEL_NAME_STUB',
        'MODEL_NAME_SMALL_STUB',
        'MODEL_NAME_PLURAL_STUB',
        'MODEL_NAME_PLURAL_SMALL_STUB',
        'MODEL_NAME_WITH_SPACE_STUB',
        'MODEL_NAME_PLURAL_WITH_SPACE_STUB',
        'MODEL_NAME_COLLECTION_STUB',
        'CONTROLLER_NAME_STUB',
        'ADMIN_RESOURCES_STUB',
        'OBJECT_NAME_STUB',
        'DB_TABLE_NAME_STUB',
        'MAIN_FIELD_TITLE_OR_NAME_STUB'
    ];
    private $replaceArray = [];
    private $fieldNamesArray = [];
    private $modelName = '';
    private $objectName = '';
    private $dBTableName = '';
    private $controllerName = '';
    private $backResourceFolderName = '';

    public function index()
    {
        $title = FindInsettingArr('business_name') . ': Code Generator';
        $msg = '';
        return view('back.module_code_generator.index')
            ->with(
                'title',
                $title
            )
            ->with(
                'msg',
                $msg
            );
    }

    public function generateCode(ModuleCodeGeneratorBackFormRequest $request)
    {
        $title = FindInsettingArr('business_name') . ': Code Generator';
        $msg = '';

        $this->modelName = $request->MODEL_NAME_STUB;
        $this->objectName = $request->OBJECT_NAME_STUB;
        $this->dBTableName = $request->DB_TABLE_NAME_STUB;
        $this->controllerName = $request->CONTROLLER_NAME_STUB;
        $this->backResourceFolderName = $request->ADMIN_RESOURCES_STUB;

        $this->replaceArray = [
            $request->MODEL_NAME_STUB,
            lcfirst($request->MODEL_NAME_STUB),
            $request->MODEL_NAME_PLURAL_STUB,
            lcfirst($request->MODEL_NAME_PLURAL_STUB),
            $request->MODEL_NAME_WITH_SPACE_STUB,
            $request->MODEL_NAME_PLURAL_WITH_SPACE_STUB,
            $request->MODEL_NAME_COLLECTION_STUB,
            $request->CONTROLLER_NAME_STUB,
            $request->ADMIN_RESOURCES_STUB,
            $request->OBJECT_NAME_STUB,
            $request->DB_TABLE_NAME_STUB,
            $request->MAIN_FIELD_TITLE_OR_NAME_STUB
        ];

        $counter = 0;
        foreach ($request->field_name as $field_name) {
            $this->fieldNamesArray[$field_name] = $request->field_label[$counter++];
        }

        $msg .= $this->generateRoutes();
        $msg .= $this->generateModel();
        $msg .= $this->generateTrait();
        $msg .= $this->generateBackEndValidator();
        $msg .= $this->generateBackEndController();
        $msg .= $this->generateBackEndViewsIndexBlade();
        $msg .= $this->generateBackEndViewsCreateBlade();
        $msg .= $this->generateBackEndViewsEditBlade();
        $msg .= $this->generateBackEndViewsSortBlade();
        $msg .= $this->generateBackEndViewsFormBlade();
        $msg .= $this->generateHelperFunctions();
        $msg .= $this->generateMigration();

        return view('back.module_code_generator.show_code')
            ->with(
                'title',
                $title
            )
            ->with(
                'msg',
                $msg
            );
    }

    private function generateRoutes()
    {
        $stubStr = Storage::get('module_generator/routes/web.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        
        $destination = 'generated_modules/' . $this->modelName . '_Module/routes/'.$this->modelName . '_routes.php';
        Storage::put($destination, $generatedCode);
        return 'Routes file '.$this->modelName . '_routes.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong><br/><span class="text-danger">Please copy routes from this file</span>';
    }

    private function generateModel()
    {
        $fieldNamesStr = "'" . implode("', '", array_keys($this->fieldNamesArray)) . "'";
        $stubStr = Storage::get('module_generator/app/Models/Back/MODEL_NAME_STUB.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        $generatedCode = str_replace('MODEL_FIELDS_STUB', $fieldNamesStr, $generatedCode);
        
        $destination = 'generated_modules/' . $this->modelName . '_Module/app/Models/Back/' . $this->modelName . '.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>Model ' . $this->modelName . '.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateTrait()
    {

        $fieldNamesStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $fieldNamesStr .= '$' . $this->objectName . 'Obj->' . $fieldName . ' = $request->input(\'' . $fieldName . '\');' . "\n";
        }
        $stubStr = Storage::get('module_generator/app/Traits/MODEL_NAME_STUBTrait.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        $generatedCode = str_replace('TRAIT_SET_FIELDS_STUB', $fieldNamesStr, $generatedCode);
        
        $destination = 'generated_modules/' . $this->modelName . '_Module/app/Traits/' . $this->modelName . 'Trait.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>' . $this->modelName . 'Trait.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateBackEndValidator()
    {

        $fieldRulesStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $fieldRulesStr .= "'" . $fieldName . "' => 'required',\n";
        }

        $fieldMessagesStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $fieldMessagesStr .= "'" . $fieldName . ".required' => __('" . $fieldLabel . " is required'),\n";
        }

        $stubStr = Storage::get('module_generator/app/Http/Requests/Back/MODEL_NAME_STUBBackFormRequest.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        $generatedCode = str_replace('VALIDATOR_RULES_STUB', $fieldRulesStr, $generatedCode);
        $generatedCode = str_replace('VALIDATOR_MESSAGES_STUB', $fieldMessagesStr, $generatedCode);
        
        $destination = 'generated_modules/' . $this->modelName . '_Module/app/Http/Requests/Back/' . $this->modelName . 'BackFormRequest.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>' . $this->modelName . 'BackFormRequest.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateBackEndController()
    {
        $filterStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $filterStr .= '
            if ($request->has(\'' . $fieldName . '\') && !empty($request->' . $fieldName . ')) {' . "\n"
                . '$query->where(\'' . $this->dBTableName . '.' . $fieldName . '\', \'like\', "%{$request->get(\'' . $fieldName . '\')}%");' . "\n"
                . '}' . "\n";
        }

        $fieldNamesStr = "'" . implode("', '", array_keys($this->fieldNamesArray)) . "'";

        $stubStr = Storage::get('module_generator/app/Http/Controllers/Back/CONTROLLER_NAME_STUBController.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        $generatedCode = str_replace('CONTROLLER_FILTER_STUB', $filterStr, $generatedCode);
        $generatedCode = str_replace('CONTROLLER_FIELDS_STUB', $fieldNamesStr, $generatedCode);

        $destination = 'generated_modules/' . $this->modelName . '_Module/app/Http/Controllers/Back/' . $this->controllerName . 'Controller.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>' . $this->controllerName . 'Controller.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }
    private function generateBackEndViewsIndexBlade()
    {

        $filterStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $filterStr .= '
            <div class="col-md-3 form-group">' . "\n" .
                '<label>' . $fieldLabel . '</label>' . "\n" .
                '<input id="'.$fieldName.'" name="'.$fieldName.'" type="text" placeholder="' . $fieldLabel . '" value="{{ request(\'' . $fieldName . '\', \'\') }}" class="form-control">' . "\n" .
                '</div>' . "\n";
        }

        $tableHeadingStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $tableHeadingStr .= '<th>' . $fieldLabel . '</th>' . "\n";
        }

        $searchAjaxDataStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $searchAjaxDataStr .= 'd.' . $fieldName . ' = $(\'#' . $fieldName . '\').val();' . "\n";
        }

        $dataTableColumnStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $dataTableColumnStr .= '
            {' . "\n" .
                'data: \'' . $fieldName . '\',' . "\n" .
                'name: \'' . $fieldName . '\'' . "\n" .
                '},' . "\n";
        }

        $dataTableFilterFieldsEventStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $dataTableFilterFieldsEventStr .= '
            $(\'#' . $fieldName . '\').on(\'keyup\', function(e) {' . "\n" .
                'oTable.draw();' . "\n" .
                'e.preventDefault();' . "\n" .
                '});' . "\n";
        }

        $stubStr = Storage::get('module_generator/resources/views/back/ADMIN_RESOURCES_STUB/index.blade.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        $generatedCode = str_replace('VIEW_INDEX_SEARCH_FIELDS', $filterStr, $generatedCode);
        $generatedCode = str_replace('VIEW_INDEX_TABLE_HEADINGS', $tableHeadingStr, $generatedCode);
        $generatedCode = str_replace('VIEW_INDEX_SEARCH_AJAX_DATA', $searchAjaxDataStr, $generatedCode);
        $generatedCode = str_replace('VIEW_INDEX_DATATABLE_COLUMNS', $dataTableColumnStr, $generatedCode);
        $generatedCode = str_replace('VIEW_INDEX_DATATABLE_FILTER_FIELD_EVENTS', $dataTableFilterFieldsEventStr, $generatedCode);

        $destination = 'generated_modules/' . $this->modelName . '_Module/resources/views/back/' . $this->backResourceFolderName . '/index.blade.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>index.blade.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateBackEndViewsCreateBlade()
    {

        $stubStr = Storage::get('module_generator/resources/views/back/ADMIN_RESOURCES_STUB/create.blade.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);

        $destination = 'generated_modules/' . $this->modelName . '_Module/resources/views/back/' . $this->backResourceFolderName . '/create.blade.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>create.blade.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateBackEndViewsEditBlade()
    {

        $stubStr = Storage::get('module_generator/resources/views/back/ADMIN_RESOURCES_STUB/edit.blade.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);

        $destination = 'generated_modules/' . $this->modelName . '_Module/resources/views/back/' . $this->backResourceFolderName . '/edit.blade.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>edit.blade.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateBackEndViewsSortBlade()
    {

        $stubStr = Storage::get('module_generator/resources/views/back/ADMIN_RESOURCES_STUB/sort.blade.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);

        $destination = 'generated_modules/' . $this->modelName . '_Module/resources/views/back/' . $this->backResourceFolderName . '/sort.blade.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>sort.blade.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateBackEndViewsFormBlade()
    {

        $formFieldsStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $formFieldsStr .= '
                <div class="col-md-12 mb-3">' . "\n" .
                '<label class="form-label">' . $fieldLabel . ':*</label>' . "\n" .
                '<input id="' . $fieldName . '" name="' . $fieldName . '" value="{{ old(\'' . $fieldName . '\', $' . $this->objectName . 'Obj->' . $fieldName . ') }}" type="text"' . "\n" .
                'class="form-control {{ hasError($errors, \'' . $fieldName . '\') }}" placeholder="' . $fieldLabel . '">' . "\n" .
                '{!! showErrors($errors, \'' . $fieldName . '\') !!}' . "\n" .
                '</div>' . "\n";
        }

        $stubStr = Storage::get('module_generator/resources/views/back/ADMIN_RESOURCES_STUB/form.blade.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        $generatedCode = str_replace('VIEW_FORM_FIELDS', $formFieldsStr, $generatedCode);

        $destination = 'generated_modules/' . $this->modelName . '_Module/resources/views/back/' . $this->backResourceFolderName . '/form.blade.php';
        Storage::put($destination, $generatedCode);
        return '<br/><br/>form.blade.php generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong>';
    }

    private function generateHelperFunctions()
    {
        $stubStr = Storage::get('module_generator/app/Helpers/my_helper.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);

        $destination = 'generated_modules/' . $this->modelName . '_Module/app/Helpers/'.$this->modelName.'_helper_functions.php';
        Storage::put($destination, $generatedCode);

        return '<br/><br/>Helper functions generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong><br/><span class="text-danger">Please copy functions from this file and paste in my_helper.php</span>';
    }

    private function generateMigration()
    {
        $tableFieldsStr = "";
        foreach ($this->fieldNamesArray as $fieldName => $fieldLabel) {
            $tableFieldsStr .= '$table->string(\''.$fieldName.'\');' . "\n";
        }

        $stubStr = Storage::get('module_generator/database/migrations/create_migration.php');
        $generatedCode = str_replace($this->stubArray, $this->replaceArray, $stubStr);
        $generatedCode = str_replace('MIGRATION_TABLE_FIELDS', $tableFieldsStr, $generatedCode);

        $fileName = date('Y_m_d').'_'.time().'_create_'.$this->dBTableName.'_table.php';
        $destination = 'generated_modules/' . $this->modelName . '_Module/database/migrations/'.$fileName;
        Storage::put($destination, $generatedCode);

        return '<br/><br/>Migration generated in :<br/><strong class="text-primary">storage/app/' . $destination.'</strong><br/><span class="text-danger">Copy this file to database/migrations<br/>run command:<br/>php artisan migrate --path=/database/migrations/'.$fileName.'<br/>or<br/>php artisan migrate:refresh --path=/database/migrations/'.$fileName.'</span>';
    }
}