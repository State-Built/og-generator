<?php
use State\OgGenerator\Image;

beforeEach(function() {
    if(file_exists("tests/results/result.png")) {
        unlink("tests/results/result.png");
    }
});

it('makes an image from bg image', function () {
    Image::fromImage("tests/images/bg.png")
        ->text("Her innocent little eyes cut through my heart like a razor")
        ->wrap(20)
        ->font("tests/fonts/static/Inter-Bold.ttf")
        ->textColor("#FFFFFF")
        ->fontSize(38)
        ->save("tests/results/result.png");

    expect(file_exists("tests/results/result.png"))->toBeTrue();
});

