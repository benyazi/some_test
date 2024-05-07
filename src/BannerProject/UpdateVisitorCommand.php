<?php

namespace BannerProject;

class UpdateVisitorCommand {

    private DataProviderInterface $dataProvider;

    public function __construct(DataProviderInterface $dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function handle(VisitorDataDto $dto): void
    {
        //update data for visitor
        $this->dataProvider->createOrUpdate($dto->ip, $dto->userAgent, $dto->pageUrl);
    }
}
