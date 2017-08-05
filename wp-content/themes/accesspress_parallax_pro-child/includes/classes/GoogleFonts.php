<?php
namespace TtkAccessParallaxPro;

/**
 * Class GoogleFonts
 * @package TtkAccessParallaxPro
 */
class GoogleFonts
{
    /**
      * Combine multiple calls to Google Fonts API (if any left) into less calls
      * To reduce HTTP(S) requests and have a cleaner DOM
     */
    const COMBINE = true;

    /**
     * Sometimes, specific fonts do not have subsets associated with them (e.g. Oxygen)
     * Thus, it's better to add them to a group that has subsets and minimize HTTP(S) requests
     */
    public $combineToSubsets = array(
        'Oxygen'
    );

    /**
     * @param $htmlDom
     * @param string $fontContainsStr
     * @return mixed
     */
    public function process($htmlDom, $fontContainsStr = 'fonts.googleapis.com')
    {
        $contentBefore = $htmlDom;

        try {
            // There has to be at least 2 calls
            if (count($htmlDom->find('link')) < 2) {
                return $htmlDom;
            }

            $linkElsHrefs = array();

            /*
            // For debugging
            if (array_key_exists('return_before_duplicate', $_GET)) {
                return $htmlDom;
            }
            */

            foreach ($htmlDom->find('link') as $key => $element) {
                if ($element->attr['rel'] === 'stylesheet'
                    && strpos($element->attr['href'], $fontContainsStr) !== false
                ) {
                    // Remove duplicate calls to Google Fonts API
                    // These are generated in accesspress_parallax_googlefont_cb() method
                    // within accesspress-google-fonts.php in "accesspress_parallax_pro" theme
                    if (in_array($element->attr['href'], $linkElsHrefs)) {
                        $htmlDom->find('link', $key)->outertext = '';
                        continue;
                    }

                    $linkElsHrefs[] = $element->attr['href'];

                    $htmlDom->find('link', $key)->outertext = '';
                }
            }

            if (class_exists('\W3TC\Root_Loader')) {
                // For `Optimize the order of styles and scripts` on GTMetrix
                // make sure no JS is loaded before the CSS of Google API Fonts
                $htmlDom->find('head', 0)->innertext = '<!-- W3TC-include-js-head -->'
                    . $htmlDom->find('head', 0)->innertext;
            }

            if (self::COMBINE && count($linkElsHrefs) > 1) {
                $htmlDom = $this->doCombine($linkElsHrefs, $htmlDom);
            }
            $content = $htmlDom;
        } catch (\Exception $e) {
            $content = $contentBefore;
        }

        return (string)$htmlDom->find('head', 0);
    }

    /**
     * @param $linkElsHrefs
     * @param $htmlDom
     * @return mixed
     */
    public function doCombine($linkElsHrefs, $htmlDom)
    {
        $fontsArray = $subsets = array();

        foreach ($linkElsHrefs as $linkElHref) {
            $queries = parse_url($linkElHref, PHP_URL_QUERY);

            if ($queries) {
                parse_str($queries, $fontQueries);

                if (array_key_exists('family', $fontQueries)) {
                    foreach ($fontQueries as $fontQuery => $value) {
                        if ($fontQuery === 'family') {
                            $familyRaw = false;
                            $family = trim($value);

                            if (strpos($family, '|') !== false) {
                                foreach (explode('|', $family) as $familyOne) {
                                    if (strpos($familyOne, ':') !== false) {
                                        list ($familyRaw, $familyTypes) = explode(':', $familyOne);
                                        $fontsArray[$familyRaw]['types'][] = $familyTypes;
                                    }
                                }
                            } else {
                                if (strpos($family, ':') !== false) {
                                    list ($familyRaw, $familyTypes) = explode(':', $family);
                                    $fontsArray[$familyRaw]['types'][] = $familyTypes;
                                }
                            }

                            if ($familyRaw && array_key_exists('subset', $fontQueries)) {
                                $fontsArray[$familyRaw]['subset'] = $fontQueries['subset'];
                            }
                        }
                    }
                }
            }
        }

        if (! empty($fontsArray) && count($fontsArray) > 1) {
            foreach (array_keys($fontsArray) as $fontFamily) {
                if (array_key_exists('types', $fontsArray[$fontFamily])) {
                    $fontsArray[$fontFamily]['types'] = self::_cleanUpFontTypes(
                        $fontsArray[$fontFamily]['types']
                    );
                }

                if (array_key_exists('subset', $fontsArray[$fontFamily])) {
                    $fontsArray[$fontFamily]['subset'] = self::_cleanUpSubset($fontsArray[$fontFamily]['subset']);
                }
            }
        }

        $fontLinkGroups = array();

        foreach ($fontsArray as $key => $values) {
            if (array_key_exists('subset', $values)) {
                $subsetHash = sha1($values['subset']);
                $fontLinkGroups['subsets'][$subsetHash]['fonts'][$key][] = $values;
                $fontLinkGroups['subsets'][$subsetHash]['subset'] = $values['subset'];
            } else {
                $fontLinkGroups['no_subsets'][$key][] = $values;
            }
        }

        if (! empty($this->combineToSubsets) && array_key_exists('no_subsets', $fontLinkGroups) && ! empty($fontLinkGroups['subsets'])) {
            foreach ($this->combineToSubsets as $noSubsetFont) {
                if (array_key_exists($noSubsetFont, $fontLinkGroups['no_subsets'])) {
                    foreach (array_keys($fontLinkGroups['subsets']) as $hash) {
                        $fontLinkGroups['subsets'][$hash]['fonts'][$noSubsetFont] = $fontLinkGroups['no_subsets'][$noSubsetFont];
                        unset($fontLinkGroups['no_subsets'][$noSubsetFont]);
                        break;
                    }
                }
            }
        }

        $finalLinkNoSubsets = '';

        if (! empty($fontLinkGroups['no_subsets'])) {
            $finalHrefNoSubsets = 'https://fonts.googleapis.com/css?family=';

            foreach ($fontLinkGroups['no_subsets'] as $fontFamily => $values) {
                $finalHrefNoSubsets .= str_replace(' ', '+', $fontFamily) . ':' . $values['types'] . '|';
            }

            $finalHrefNoSubsets = trim($finalHrefNoSubsets, '|');

            $finalLinkNoSubsets = '<link href="' . $finalHrefNoSubsets . '" rel="stylesheet" type="text/css" />';
        }

        $finalLinksWithSubsets = '';

        if (! empty($fontLinkGroups['subsets'])) {
            foreach ($fontLinkGroups['subsets'] as $groups) {
                $finalHrefWithSubsets = 'https://fonts.googleapis.com/css?family=';

                foreach ($groups['fonts'] as $fontFamily => $values) {
                    $finalHrefWithSubsets .= str_replace(' ', '+', $fontFamily) . ':' . $values[0]['types'] . '|';
                }

                $finalHrefWithSubsets = trim($finalHrefWithSubsets, '|');

                $finalHrefWithSubsets .= '&subset=' . $groups['subset'];

                $finalLinksWithSubsets .= '<link href="' . $finalHrefWithSubsets . '" rel="stylesheet" type="text/css" />';
            }
        }

        $headEl = $htmlDom->find('head', 0);
        $headEl->innertext = $finalLinkNoSubsets .
            $finalLinksWithSubsets .
            $headEl->innertext;
        
        return $htmlDom;
    }

    /**
     * @param $types
     * @return string
     */
    private static function _cleanUpFontTypes($types)
    {
        $typesAll = implode(',', $types);

        $newTypes = array();

        foreach (explode(',', $typesAll) as $type) {
            $newTypes[] = $type;
        }

        sort($newTypes);

        $newTypes = array_unique($newTypes);

        $newTypesList = implode(',', $newTypes);

        return $newTypesList;
    }

    /**
     * @param $subset
     * @return string
     */
    private static function _cleanUpSubset($subset)
    {
        $subset = trim(trim($subset, ','));

        if (strpos($subset, ',') !== false) {
            $subsetAll = explode(',', $subset);
            sort($subsetAll);

            return implode(',', $subsetAll);
        }

        return $subset;
    }
}
