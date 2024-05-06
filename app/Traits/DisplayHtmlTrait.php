<?php

namespace App\Traits;

use App\Exceptions\RestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait DisplayHtmlTrait
{
    public function displayStatus($status)
    {
        return ($status == 'active')
            ? '<span class="badge badge-success">' . $status . '</span>'
            : '<span class="badge badge-warning">' . $status . '</span>';
    }

    public function displayPhoto($photo = "assets/admin/img/thumbnail-default.jpg")
    {
        return '<img src="' . url($photo) . '" class="img-fluid zoom" style="max-width:80px"
                                                alt="' . $photo . '">';
    }

    public function displayEditButton($id)
    {
        return '<a href="' . route('banners.edit', $id) . '"
        class="btn btn-primary btn-sm float-left mr-1"
        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
        title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>';
    }

    public function displayDeleteButton($id)
    {
        $csrfField = '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $methodField = '<input type="hidden" name="_method" value="DELETE">';
        return '<form method="POST" action="' . route('banners.destroy', [$id]) . '">'
            . $csrfField
            . $methodField
            . '<button type="button" class="btn btn-danger btn-sm dltBtn" data-id="' . $id . '"
            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
            data-placement="bottom" title="Delete"><i
                class="fas fa-trash-alt"></i></button>
        </form>';
    }

    public function displayAction($id)
    {
        $html = '';
        $html .= $this->displayEditButton($id);
        $html .= $this->displayDeleteButton($id);

        return $html;
    }
}
