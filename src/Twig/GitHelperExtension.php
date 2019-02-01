<?php

namespace Kuwar\AssetVersion\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * A class to retrieve the git last commit hash.
 * (We might not need this class in the future but for the time being it helps in solving the javascript/css cache problem)
 *
 * @author Deepak Pandey
 */
class GitHelperExtension extends Twig_Extension
{

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('getLastCommitHash', [$this, 'getLastCommitHash']),
        ];
    }

    /**
     * Returns the last commit hash of the GIT repository being used.
     * Note: It returns null if current directory is not a GIT repository
     *
     * @return string|null
     */
    public function getLastCommitHash()
    {
        ob_start();
        @exec('git rev-parse --verify HEAD 2> /dev/null', $output);
        $hash = $output[0];
        ob_end_clean();

        return '?v=' . substr($hash, 1, 10);
    }

    public function getName()
    {
        return 'git_last_commit_hash';
    }
}
