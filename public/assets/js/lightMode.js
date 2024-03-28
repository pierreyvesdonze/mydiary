$(document).ready(function() {
    // Change Theme Setting with a Switch
    const currentTheme = localStorage.getItem('theme');
    const switchElem = $('#theme-switch');
  
    const setTheme = function(isDark) {
        if (isDark) {
            switchElem.addClass('is-dark');
            $('.switch-mode-icon').text('wb_sunny');
        } else {
            switchElem.removeClass('is-dark');
            switchElem.addClass('');
            $('.switch-mode-icon').text('brightness_3');
          }
        };
  
    if (switchElem.length > 0) {
      // Load
      if (currentTheme) setTheme(true);
      // Change
      switchElem.on('click', function(e) {
        e.preventDefault();
        if (!switchElem.hasClass('is-dark')) {
          // Dark Theme
          $('html').attr('theme', 'dark');
          localStorage.setItem('theme', 'dark');
          setTheme(true);
        } else {
          // Light Theme
          $('html').removeAttr('theme');
          localStorage.removeItem('theme');
          setTheme(false);
        }
      });
    }
  });
  