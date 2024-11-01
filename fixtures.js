/* global statsfc_lang */

var $j = jQuery;

function StatsFC_Fixtures (key) {
  this.referer = '';
  this.key = key;
  this.competition = '';
  this.group = '';
  this.season = '';
  this.team = '';
  this.from = '';
  this.to = '';
  this.limit = '';
  this.highlight = '';
  this.showBadges = false;
  this.showDates = true;
  this.timezone = '';
  this.omitErrors = false;
  this.useDefaultCss = false;
  this.lang = 'en';

  this.translate = function (key) {
    if (
      typeof statsfc_lang === 'undefined' ||
      typeof statsfc_lang[key] === 'undefined' ||
      statsfc_lang[key].length === 0
    ) {
      return key;
    }

    return statsfc_lang[key];
  };

  this.display = function (placeholder) {
    this.loadLang('statsfc-lang', this.lang);

    var $placeholder;

    switch (typeof placeholder) {
      case 'string':
        $placeholder = $j('#' + placeholder);
        break;
      case 'object':
        $placeholder = placeholder;
        break;
      default:
        return;
    }

    if ($placeholder.length === 0) {
      return;
    }

    if (this.useDefaultCss === true || this.useDefaultCss === 'true') {
      this.loadCss('statsfc-fixtures-css');
    }

    if (typeof this.referer !== 'string' || this.referer.length === 0) {
      this.referer = window.location.hostname || window.top.location.hostname;
    }

    var $container = $j('<div>').addClass('sfc_fixtures');

    // Store globals variables here so we can use it later.
    var competition = this.competition;
    var highlight = this.highlight;
    var showBadges = (this.showBadges === true || this.showBadges === 'true');
    var showDates = (this.showDates === true || this.showDates === 'true');
    var omitErrors = (this.omitErrors === true || this.omitErrors === 'true');
    var translate = this.translate;

    $j.getJSON(
      'https://widgets.statsfc.com/api/fixtures.json?callback=?',
      {
        key: this.key,
        domain: this.referer,
        competition: this.competition,
        group: this.group,
        season: this.season,
        team: this.team,
        from: this.from,
        to: this.to,
        limit: this.limit,
        timezone: this.timezone,
        lang: this.lang,
      },
      function (data) {
        if (data.error) {
          if (omitErrors) {
            return;
          }

          var $error = $j('<p>').css('text-align', 'center');

          if (data.customer && data.customer.attribution) {
            $error.append(
              $j('<a>').attr({
                href: 'https://statsfc.com',
                title: 'Football widgets and API',
                target: '_blank',
              }).text('Stats FC'),
              ' – ',
            );
          }

          $error.append(translate(data.error));

          $container.append($error);

          return;
        }

        var $tables = $j('<div>'), $tableNoDate, $tbodyNoDate;

        if (! showDates) {
          $tableNoDate = $j('<table>');
          $tbodyNoDate = $j('<tbody>');
        }

        $j.each(data.matches, function (date, matches) {
          var $tableDate, $theadDate, $tbodyDate;

          if (showDates) {
            $tableDate = $j('<table>');
            $theadDate = $j('<thead>');
            $tbodyDate = $j('<tbody>');

            $theadDate.append(
              $j('<tr>').append(
                $j('<th>').attr('colspan', 5).text(date),
              ),
            );
          }

          $j.each(matches, function (key, match) {
            var $row = $j('<tr>');
            var $home = $j('<td>').addClass('sfc_team sfc_home sfc_badge_' + match.homepath).text(match.home);
            var $away = $j('<td>').addClass('sfc_team sfc_away sfc_badge_' + match.awaypath).text(match.away);

            if (showBadges) {
              $home.addClass('sfc_badge').css('background-image', 'url(https://cdn.statsfc.com/kit/' + match.homeshirt + ')');
              $away.addClass('sfc_badge').css('background-image', 'url(https://cdn.statsfc.com/kit/' + match.awayshirt + ')');
            }

            if (highlight === match.home || highlight === match.homefull) {
              $home.addClass('sfc_highlight');
            } else if (highlight === match.away || highlight === match.awayfull) {
              $away.addClass('sfc_highlight');
            }

            if (competition.length === 0) {
              $away.append(
                $j('<span>').addClass('sfc_competition').append(
                  $j('<abbr>').attr('title', match.competition).text(match.competitionkey),
                ),
              );
            }

            $row.append(
              $home,
              $j('<td>').addClass('sfc_time').text(translate(match.status)),
              $away,
            );

            if (showDates) {
              $tbodyDate.append($row);
            } else {
              $tbodyNoDate.append($row);
            }
          });

          if (showDates) {
            $tableDate.append($theadDate, $tbodyDate);
            $tables.append($tableDate);
          }
        });

        if (! showDates) {
          $tableNoDate.append($tbodyNoDate);
          $tables.append($tableNoDate);
        }

        $container.append($tables);

        if (data.customer.attribution) {
          $container.append(
            $j('<div>').attr('class', 'sfc_footer').append(
              $j('<p>').append(
                $j('<small>').append('Powered by ').append(
                  $j('<a>').attr({
                    href: 'https://statsfc.com',
                    title: 'StatsFC – Football widgets',
                    target: '_blank',
                  }).text('StatsFC.com'),
                ),
              ),
            ),
          );
        }
      },
    );

    $placeholder.append($container);
  };

  this.loadCss = function (id) {
    if (document.getElementById(id)) {
      return;
    }

    var css, fcss = (document.getElementsByTagName('link')[0] || document.getElementsByTagName('script')[0]);

    css = document.createElement('link');
    css.id = id;
    css.rel = 'stylesheet';
    css.href = 'https://cdn.statsfc.com/css/fixtures.css';

    fcss.parentNode.insertBefore(css, fcss);
  };

  this.loadLang = function (id, l) {
    if (document.getElementById(id)) {
      return;
    }

    var lang, flang = document.getElementsByTagName('script')[0];

    lang = document.createElement('script');
    lang.id = id;
    lang.src = 'https://cdn.statsfc.com/js/lang/' + l + '.js';

    flang.parentNode.insertBefore(lang, flang);
  };
}

/**
 * Load widgets dynamically using data-* attributes
 */
$j('div.statsfc-fixtures').each(function () {
  var key = $j(this).attr('data-key'),
    fixtures = new StatsFC_Fixtures(key),
    data = $j(this).data();

  for (var i in data) {
    fixtures[i] = data[i];
  }

  fixtures.display($j(this));
});
