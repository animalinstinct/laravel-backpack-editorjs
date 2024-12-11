@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    <input
    hidden
      id="input_{{ $field['name'] }}"   
      type="text" 
      name="{{ $field['name'] }}" 
      value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}" 
    > 
    <div style="width: 100%; min-height: 200px;border:1px solid rgba(0, 40, 100, .12);padding:10px;">
        <div id="editor_{{ $field['name'] }}" style="width:100%;min-height: 200px:padding:10px"></div>
    </div>
    @if (isset($field['hint'])) 
    <p class="help-block">{!! $field['hint'] !!}</p> @endif 
  
    @include('crud::fields.inc.wrapper_end')
  
  @if ($crud->checkIfFieldIsFirstOfItsType($field)) 
        @push('crud_fields_styles') 
        @endpush
        @push('crud_fields_scripts') 
          <script src="{{ asset('packages/editorjs/editor.js') }}"></script>
        @endpush 
  @endif
  @csrf
  <script>
    window.addEventListener('DOMContentLoaded', () => {
        const fieldValue = `{!! isset($field['value']) ? $field['value'] : '' !!}`;

        function isJSONString(str) {
          try {
            JSON.parse(str);
            return true;
          } catch (e) {
            return false;
          }
        }

        let value = undefined;

        if (fieldValue && isJSONString(fieldValue)) {
          value = JSON.parse(fieldValue);
        }

        const appUrl = '{{ config('app.url') }}';

        const editor = window.EditorJS('{{ $field['name'] }}', appUrl ?? 'http://localhost:8000', value);
    })
  </script>