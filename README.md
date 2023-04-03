## WordPress Example Theme Using Morph

![image](https://user-images.githubusercontent.com/18317878/229399041-196e5d6b-05a5-49d1-9855-b1fb78a5360f.png)

This is meant to be an example of how [Morph](https://github.com/boxybird/morph) works within a theme rather than a fully functional theme. It is not meant to be used as a starter theme, but rather as a reference for how to use Morph in your own theme.

### Files of Note

* `functions.php` - Composer autoload and optional Morph component folder override. [See details](https://github.com/boxybird/morph#hooks)

* `index.php` - The main template file. This is where the components are called and displayed on the front-end.

* `components/counter-class.php` - An a example of a component using the `morph_render` helper class.

* `components/counter-procedural.php` - An a example of a component using procedural code.

### Installation

Clone this repository into the WordPress themes directory and follow the instructions in the [Morph README](https://github.com/boxybird/morph).


### License
[MIT license](https://opensource.org/licenses/MIT)
