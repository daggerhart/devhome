<?php

/**
 * Load the settings file and set defaults
 *
 * @param $file
 *
 * @return array
 */
function get_settings( $file )
{
    $options = parse_yaml_file( $file );

    // top-level requirements
    $settings = array_replace([
        'roots'            => [],
        'discovery_filter' => '',
        'utils'            => [],
        'projects'         => [],
        'public_root'      => 'www',
        'ignore'           => [],
    ], $options);

    // look in all given root folders
    foreach ($settings['roots'] as $root) {

        // set default data for projects
        foreach ($settings['projects'] as $key => &$project) {
            // project requirements
            $project = array_replace([
                'name'        => 'name is required',
                'key'         => $key,
                'folder'      => $key,
                'description' => null,
                'public_root' => $settings['public_root'],
                'links'       => [],
            ], $project);

            // infer the source of the project
            $project['source'] = implode('/', [
                $root,
                $project['folder'],
                $project['public_root'],
            ]);

            // set default data for project links
            foreach ($project['links'] as $link_key => &$link) {
                $tmp  = explode('/', $link['url']);
                $link = array_replace([
                    'key'  => $link_key,
                    'name' => $tmp[2],
                    'icon' => 'cog',
                ], $link);
            }
        }
    }

    return $settings;
}

/**
 * Look through root folders for non-configured projects
 *
 * @param $settings
 *
 * @return array
 */
function discover_projects( $settings ){
    $discovered = [];

    $finder = new \Symfony\Component\Finder\Finder();
    $finder
        ->depth('== 0')
        ->directories()
        ->in( $settings['roots'] );

    // allow settings to determine a pattern of search
    if ( $settings['discovery_filter'] ) {
        $finder->name( $settings['discovery_filter'] );
    }

    foreach ($finder as $dir) {
        $folder = $dir->getRelativePathname();

        // skip folders that are manually configured
        if ( isset( $settings['projects'][$folder] ) ) {
            continue;
        }
        // skip folders that are ignored
        if ( in_array( $folder, $settings['ignore'] ) ) {
            continue;
        }

        $realpath = $dir->getRealPath();

        // look for a public folder
        if ( file_exists( $realpath . '/' . $settings['public_root'] ) ) {
            $source = $realpath . '/' . $settings['public_root'];
        }
        else {
            $source = $realpath;
        }

        $discovered[ $folder ] = [
            'folder' => $folder,
            'url' => 'http://'.$folder,
            'source' => $source,
        ];
    }

    return $discovered;
}

/**
 * Simple templating function
 *
 * @param $path
 * @param array $data
 *
 * @return string
 */
function template( $path, $data = [] ){
    $output = "<!-- template: $path not found -->";
    $template = realpath( APP_PATH . '/templates/' . $path );

    if ( file_exists( $template ) ) {
        ob_start();
            extract( $data );
            include $template;
        $output = ob_get_clean();
    }

    return $output;
}

/**
 * Yaml parse a string
 *
 * @param $string
 *
 * @return array
 */
function parse_yaml( $string ){
    return \Symfony\Component\Yaml\Yaml::parse( $string );
}

/**
 * Yaml parse the contents of a file
 *
 * @param $file
 *
 * @return array
 */
function parse_yaml_file( $file ){
    $content = file_get_contents( $file );
    return parse_yaml( $content );
}

/**
 * Simple debug function
 */
function d()
{
    $vs = func_get_args();
    foreach ($vs as $v) {
        dump($v);
    }
}
