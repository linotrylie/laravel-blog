<?php

namespace App\Presenters;

use App\Transformers\HomeMenuTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HomeMenuPresenter.
 *
 * @package namespace App\Presenters;
 */
class HomeMenuPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new HomeMenuTransformer();
    }
}
