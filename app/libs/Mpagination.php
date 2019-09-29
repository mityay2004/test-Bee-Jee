<?php 

namespace app\libs;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use \system\Router;

class Mpagination 
{
    public $prevIcon = '«',
    $nextIcon = '»';

    private $router;
    
    private $page, $uriCurrent;

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function generate_link($dp)
    {
        if ($dp['pageCount'] <= 1){
	    return '';
        }
        $get = $this->router->getQueryUrl();
        if (!isset($get)) {
            $get = [];
        }
        $this->page = $get['page'] ?? '1';
        
        if (array_key_exists('page', $get)) {
            unset($get['page']);
        }
        
        $this->uriCurrent = $this->router->getPathUrl() . '?';

        $out = '';
        $class_str = 'class="' . (isset($dp['class']) ? ($dp['class']) : '') . '"';
        $out .= '<ul ' . $class_str . '>';

        if ($this->page <= 1 ){
            $out .= '
                <li class="page-item disabled">
                    <a class="page-link">' . $this->prevIcon . '</a>
                </li>';
        } else {
            $prevPage = $this->page - 1;
            $get = $this->_setPageParam($get, $prevPage);
            $out .= '
                <li class="page-item">
                    <a href="'
                    . rtrim($this->uriCurrent . http_build_query($get), '?' )
                    . '" class="page-link">'
                    . $this->prevIcon
                    . '</a>
                </li>';
        }

	if ($dp['pageCount'] <= 10) {
            for($a=1; $a<=$dp['pageCount']; $a++) {
                $out .= $this->_pagesBlock($get, $a);
            }
        } else {
            if ($this->page > $dp['pageCount']-5) {
                for($a = $dp['pageCount']-10; $a <= $dp['pageCount']-5; $a++){
                    $out .= $this->_pagesBlock($get, $a);
                }
            } else if ($this->page > $dp['pageCount']-10) {
                for ($a = $dp['pageCount']-10; $a <= $dp['pageCount']-5; $a++){
                    $out .= $this->_pagesBlock($get, $a);
                }
            } else if ($this->page < 3){
                for ($a = 1; $a <= 5; $a++) {
                    $out .= $this->_pagesBlock($get, $a);
                }
                $out .= '<li>...</li>';
            } else {
                for($a = $this->page-2; $a <= $this->page+2; $a++){
                    $out .= $this->_pagesBlock($get, $a);
                }
                $out .= '<li>...</li>';
            }
            for($a = $dp['pageCount']-4; $a <= $dp['pageCount']; $a++){
                $out .= $this->_pagesBlock($get, $a);
            }
        }
        if ($this->page == $dp['pageCount'] ){
            $out .= '<li class="page-item disabled">
                        <a class="page-link">' . $this->nextIcon . '</a>
                    </li>';
        } else {
            $nextPage = $this->page + 1;
            $get = $this->_setPageParam($get, $nextPage);
            $out .= '<li class="page-item">
                        <a href="' . $this->uriCurrent . http_build_query($get) . '" class="page-link">' . $this->nextIcon . '</a>
                    </li>';
        }
        $out .= '</ul>';
       return $out;
    }

    protected function _setPageParam(array $get, int $index): array
    {
        if ($index == 1) {
            unset($get['page']);
        } else {
            $get['page'] = $index;
        }
        return $get;
    }

    protected function _pagesBlock(array $get, int $index): string
    {
        $out = '';
        $get = $this->_setPageParam($get, $index);
        $out .= '<li class="' . (($index == $this->page) ? 'active ' : '') . 'page-item">';
        $out .= '<a class="page-link" href="'
                . rtrim($this->uriCurrent . http_build_query($get), '?')
                . '">' . $index . '</a>';
        $out .= '</li>';
        return $out;
    }
}