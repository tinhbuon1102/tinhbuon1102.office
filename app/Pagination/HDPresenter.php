<?php 

namespace App\Pagination;

use Illuminate\Pagination\BootstrapThreePresenter;

class HDPresenter extends BootstrapThreePresenter {

    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<ul class="pagination custom-pagination">%s %s %s %s %s</ul>',
                $this->getFirst(),
                $this->getButtonPre(),
                $this->getLinks(),
                $this->getButtonNext(),
                $this->getLast()
            );
        }
        return "";
    }

    public function getLast()
    {
        $url = $this->paginator->url($this->paginator->lastPage());
        $btnStatus = '';

        if($this->paginator->lastPage() == $this->paginator->currentPage()){
            $btnStatus = 'disabled';
        }
        return $btn = "
            <li class='custom-arrow'>
                <a href='".$url."' class='btn last paginate_button Pagination-link ".$btnStatus."' id='pagination_top_last'>
                    <span>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' class='flicon-pagination-last'>
                            <path d='M2 1l5 5-5 5M9.5 1c.28 0 .5.22.5.5v9c0 .28-.22.5-.5.5s-.5-.22-.5-.5v-9c0-.28.22-.5.5-.5z'></path>
                        </svg>
                    </span>
                </a>
            <li>";
    }

    public function getFirst()
    {
        $url = $this->paginator->url(1);
        $btnStatus = '';

        if(1 == $this->paginator->currentPage()){
            $btnStatus = 'disabled';
        }
        return $btn = "
        <li class='custom-arrow'>
            <a href='".$url."' class='btn first paginate_button Pagination-link ".$btnStatus."' id='pagination_top_first'>
                <span>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' class='flicon-pagination-first'>
                        <path d='M10 11L5 6l5-5M2.5 11c-.28 0-.5-.22-.5-.5v-9c0-.28.22-.5.5-.5s.5.22.5.5v9c0 .28-.22.5-.5.5z'></path>
                    </svg>
                </span>
            </a>

        </li>";
    }

    public function getButtonPre()
    {
        $url = $this->paginator->previousPageUrl();
        $btnStatus = '';

        if(empty($url)){
            $btnStatus = 'disabled';
        }
        return $btn = "
        <li class='custom-arrow'>
            <a href='".$url."' class='btn previous paginate_button Pagination-link ".$btnStatus."' id='pagination_top_prev'>
                <span>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' class='flicon-pagination-prev'>
                        <path d='M8 11L3 6l5-5v10z'></path>
                    </svg>
                </span>
            </a>
        </li>";
    }

    public function getButtonNext()
    {
        $url = $this->paginator->nextPageUrl();
        $btnStatus = '';

        if(empty($url)){
            $btnStatus = 'disabled';
        }
        return $btn = "
        <li class='custom-arrow'>
            <a href='".$url."' class='btn next paginate_button Pagination-link ".$btnStatus."' id='pagination_top_next'>
                <span>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' class='flicon-pagination-next'>
                        <path d='M4 1l5 5-5 5'></path>
                    </svg>
                </span>
            </a>
        </li>";
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

        return '<li><a href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a></li>';
    }

}