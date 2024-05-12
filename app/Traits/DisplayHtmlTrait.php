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

    public function displayOrderStatus($status)
    {
        if ($status == 'new')
            return '<span class="badge badge-primary">NEW</span>';
        elseif ($status == 'process')
            return '<span class="badge badge-warning">Processing</span>';
        elseif ($status == 'delivered')
            return '<span class="badge badge-success">Delivered</span>';
        else
            return '<span class="badge badge-danger">' . $status . '</span>';
    }

    public function displayYesNo($status)
    {
        return ($status == 1)
            ? '<span class="badge badge-success">Yes</span>'
            : '<span class="badge badge-warning">No</span>';
    }

    public function displayPhoto($photo = "assets/admin/img/thumbnail-default.jpg")
    {
        return '<img src="' . $photo . '" class="img-fluid zoom" style="max-width:80px"
                                                alt="' . $photo . '">';
    }

    public function displayEditButton($id, $route)
    {
        return '<a href="' . route($route . ".edit", $id) . '"
        class="btn btn-primary btn-sm float-left mr-1"
        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
        title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>';
    }

    public function displayDeleteButton($id, $route)
    {
        $csrfField = '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $methodField = '<input type="hidden" name="_method" value="DELETE">';
        return '<form method="POST" action="' . route($route . ".destroy", [$id]) . '">'
            . $csrfField
            . $methodField
            . '<button type="button" class="btn btn-danger btn-sm dltBtn" data-id="' . $id . '"
            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
            data-placement="bottom" title="Delete"><i
                class="fas fa-trash-alt"></i></button>
        </form>';
    }

    public function displayShowButton($id, $route)
    {
        return '<a href="' . route($route . '.show', $id) . '"
        class="btn btn-warning btn-sm float-left mr-1"
        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
        title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>';
    }

    public function displayAction($id, $route)
    {
        $html = '';
        $html .= $this->displayEditButton($id, $route);
        $html .= $this->displayDeleteButton($id, $route);

        return $html;
    }

    public function displayRating($rating)
    {
        $html = '<ul style="list-style:none">';
        for ($i = 1; $i <= 5; $i++) {
            if ($rating >= $i) {
                $html .= '<li style="float:left;color:#F7941D;"><i class="fa fa-star"></i></li>';
            } else {
                $html .= '<li style="float:left;color:#F7941D;"><i class="far fa-star"></i></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}
