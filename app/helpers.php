<?php 

// You need to register this in composer.json file in autoload section.

function current_user() {
  return auth()->user();
}