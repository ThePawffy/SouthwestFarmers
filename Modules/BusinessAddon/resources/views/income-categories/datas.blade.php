@foreach($income_categories as $income_category)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="w-60 checkbox table-data">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $income_category->id }}">
        </td>
        <td class="table-data">{{ ($income_categories->currentPage() - 1) * $income_categories->perPage() + $loop->iteration }}</td>
        <td class="text-start table-data">{{ $income_category->categoryName }}</td>
        <td class="text-start table-data">{{ $income_category->categoryDescription }}</td>
        <td class="table-data">
            <label class="switch">
                <input type="checkbox" {{ $income_category->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('business.income-categories.status', $income_category->id) }}">
                <span class="slider round"></span>
            </label>
        </td>
        <td class="print-d-none table-data">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a  href="#income-categories-edit-modal" data-bs-toggle="modal" class="income-categories-edit-btn"
                        data-url="{{ route('business.income-categories.update', $income_category->id) }}"
                        data-income-categories-name="{{ $income_category->categoryName }}" data-income-categories-description="{{ $income_category->categoryDescription }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.income-categories.destroy', $income_category->id) }}" class="confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
