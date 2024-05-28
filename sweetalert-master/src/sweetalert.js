/*
 * This makes sure that we can use the global
 * swal() function, instead of swal.default()
 * See: https://github.com/webpack/webpack/issues/3929
 */

if (typeof window !== 'undefined') {
  require('sweetalert.css');
}

import 'polyfills';

import swal from './core';

export default swal;
