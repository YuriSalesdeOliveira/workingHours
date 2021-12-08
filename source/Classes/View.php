<?php

namespace Source\Classes;

class View
{
    private $base_dir;
    private $extension;
    private $layout;
    private $view;
    private $data;

    public function __construct(string $base_dir, string $extension)
    {
        $this->base_dir = $base_dir;

        $this->extension = $extension;
    }

    public function create(string $base_dir, ?string $extension = null): View
    {
        $this->base_dir = $base_dir;

        if ($extension) {

            $this->extension = $extension;
        }

        return $this;
    }

    public function layout(?string $layout): View
    {
        $this->layout = $layout;

        return $this;
    }

    public function addData(array $data = []): View
    {
        $this->data = $this->data ? $this->data + $data : $data;

        return $this;
    }

    public function load(string $view, array $data = [], ?string $layout = null): View
    {
        if ($layout) {

            $this->layout = $layout;
        }

        $this->view = $view;
        $this->data = $this->data ? $this->data + $data : $data;

        return $this;
    }

    public function render(): View
    {
        foreach ($this->data as $key => $value) {

            $$key = $value;
        }

        $v = $this;

        $require = $this->layout ?? $this->view;

        require_once($this->base_dir . "/{$require}.{$this->extension}");

        return $this;
    }

    public function view(string $view = null): void
    {
        foreach ($this->data as $key => $value) {

            $$key = $value;
        }

        $v = $this;

        $require = $view ?? $this->view;

        require_once($this->base_dir . "/{$require}.{$this->extension}");
    }
}
