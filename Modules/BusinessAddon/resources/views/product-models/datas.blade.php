@foreach($models as $model)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $model->id }}">
        </td>

        <td>{{ $models->firstItem() + $loop->index }}</td>

        <td class="text-start">{{ $model->name }}</td>
        <td class="text-center">
                <label class="switch">
                    <input type="checkbox" {{ $model->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('business.product-models.status', $model->id) }}">
                    <span class="slider round"></span>
                </label>
        </td>
        <td class="d-print-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a  href="#model-edit-modal" data-bs-toggle="modal" class="model-edit-btn" data-url="{{ route('business.product-models.update', $model->id) }}" data-model-name="{{ $model->name }}" data-model-status="{{ $model->status }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.product-models.destroy', $model->id) }}" class="confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
