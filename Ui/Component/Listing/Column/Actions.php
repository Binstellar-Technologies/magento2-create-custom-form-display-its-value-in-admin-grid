<?php

namespace Binstellar\Freehomemeasure\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;


class Actions extends Column
{

    const URL_PATH_EDIT = 'freehomemeasure/freehomemeasure/edit';
    const URL_PATH_DELETE = 'freehomemeasure/freehomemeasure/delete';
    const URL_PATH_DETAILS = 'freehomemeasure/freehomemeasure/details';


    protected $urlBuilder;


    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    public function prepareDataSource(array $dataSource)
    {   if (isset($dataSource['data']['items'])) {
        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['id'])) {
                $item[$this->getData('name')] = [
                    'view' => [
                        'href' => $this->urlBuilder->getUrl(
                            static::URL_PATH_EDIT,
                            [
                                'id' => $item['id']
                            ]
                        ),
                        'label' => __('More Details')
                    ]
                    // 'delete' => [
                    //     'href' => $this->urlBuilder->getUrl(
                    //         static::URL_PATH_DELETE,
                    //         [
                    //             'partner' => $item['id']
                    //         ]
                    //     ),
                    //     'label' => __('Delete'),
                    //     'confirm' => [
                    //         'title' => __('Delete "${ $.$data.name }"'),
                    //         'message' => __('Are you sure you wan\'t to delete a "${ $.$data.name }" record?')
                    //     ]
                    // ]
                ];
            }
        }
    }

    return $dataSource;
    }

}