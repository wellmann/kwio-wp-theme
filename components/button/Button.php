<?php

declare(strict_types=1);

namespace KWIO\Theme\Component;

class Button extends BaseComponent
{
    public function __construct(
        public readonly string $type
        // phpcs:ignore Squiz.WhiteSpace.ScopeClosingBrace
    ) {}

    public function render(): string
    {
        parent::render();

        $this->setView();
    }
}