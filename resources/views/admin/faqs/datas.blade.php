@foreach ($faqs as $faq)
    <tr>
        <td class="w-60 checkbox table-data">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item"
                    value="{{ $faq->id }}" data-url="{{ route('admin.faqs.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $faqs->firstItem() + $loop->index }}</td>
        <td>{{ Str::words($faq->question, 5, '...') }}</td>
        <td>{{ Str::words($faq->answer, 7, '...') }}</td>
        <td>
            <label class="switch">
                <input type="checkbox" {{ $faq->status == 1 ? 'checked' : '' }} class="status"
                    data-url="{{ route('admin.faqs.status', $faq->id) }}">
                <span class="slider round"></span>
            </label>
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#faq-edit-modal" data-bs-toggle="modal" class="faq-edit-btn"
                            data-url="{{ route('admin.faqs.update', $faq->id) }}"
                            data-question="{{ $faq->question ?? '' }}" data-answer="{{ $faq->answer ?? '' }}"><i
                                class="fal fa-pencil-alt"></i>{{ __('Edit') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.faqs.destroy', $faq->id) }}" class="confirm-action"
                            data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
