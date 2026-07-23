<?php

namespace Composer\Installers;

class MoodleInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        // Core plugin and subplugin types.
        'core'               => '{$prefix}',
        'aiplacement'        => '{$prefix}{$public}ai/placement/{$name}/',
        'aiprovider'         => '{$prefix}{$public}ai/provider/{$name}/',
        'antivirus'          => '{$prefix}{$public}lib/antivirus/{$name}/',
        'assignfeedback'     => '{$prefix}{$public}mod/assign/feedback/{$name}/',
        'assignsubmission'   => '{$prefix}{$public}mod/assign/submission/{$name}/',
        'auth'               => '{$prefix}{$public}auth/{$name}/',
        'availability'       => '{$prefix}{$public}availability/condition/{$name}/',
        'bbbext'             => '{$prefix}{$public}mod/bigbluebuttonbn/extension/{$name}/',
        'block'              => '{$prefix}{$public}blocks/{$name}/',
        'booktool'           => '{$prefix}{$public}mod/book/tool/{$name}/',
        'cachelock'          => '{$prefix}{$public}cache/locks/{$name}/',
        'cachestore'         => '{$prefix}{$public}cache/stores/{$name}/',
        'calendartype'       => '{$prefix}{$public}calendar/type/{$name}/',
        'communication'      => '{$prefix}{$public}communication/provider/{$name}/',
        'contenttype'        => '{$prefix}{$public}contentbank/contenttype/{$name}/',
        'coursereport'       => '{$prefix}{$public}course/report/{$name}/',
        'customfield'        => '{$prefix}{$public}customfield/field/{$name}/',
        'datafield'          => '{$prefix}{$public}mod/data/field/{$name}/',
        'dataformat'         => '{$prefix}{$public}dataformat/{$name}/',
        'datapreset'         => '{$prefix}{$public}mod/data/preset/{$name}/',
        'editor'             => '{$prefix}{$public}lib/editor/{$name}/',
        'enrol'              => '{$prefix}{$public}enrol/{$name}/',
        'factor'             => '{$prefix}{$public}admin/tool/mfa/factor/{$name}/',
        'fileconverter'      => '{$prefix}{$public}files/converter/{$name}/',
        'filter'             => '{$prefix}{$public}filter/{$name}/',
        'format'             => '{$prefix}{$public}course/format/{$name}/',
        'forumreport'        => '{$prefix}{$public}mod/forum/report/{$name}/',
        'gradeexport'        => '{$prefix}{$public}grade/export/{$name}/',
        'gradeimport'        => '{$prefix}{$public}grade/import/{$name}/',
        'gradepenalty'       => '{$prefix}{$public}grade/penalty/{$name}/',
        'gradereport'        => '{$prefix}{$public}grade/report/{$name}/',
        'gradingform'        => '{$prefix}{$public}grade/grading/form/{$name}/',
        'h5plib'             => '{$prefix}{$public}h5p/h5plib/{$name}/',
        'local'              => '{$prefix}{$public}local/{$name}/',
        'logstore'           => '{$prefix}{$public}admin/tool/log/store/{$name}/',
        'ltiservice'         => '{$prefix}{$public}mod/lti/service/{$name}/',
        'ltisource'          => '{$prefix}{$public}mod/lti/source/{$name}/',
        'media'              => '{$prefix}{$public}media/player/{$name}/',
        'message'            => '{$prefix}{$public}message/output/{$name}/',
        'mlbackend'          => '{$prefix}{$public}lib/mlbackend/{$name}/',
        'mnetservice'        => '{$prefix}{$public}mnet/service/{$name}/',
        'mod'                => '{$prefix}{$public}mod/{$name}/',
        'monitoringexporter' => '{$prefix}{$public}admin/tool/monitoring/exporter/{$name}/',
        'paygw'              => '{$prefix}{$public}payment/gateway/{$name}/',
        'plagiarism'         => '{$prefix}{$public}plagiarism/{$name}/',
        'portfolio'          => '{$prefix}{$public}portfolio/{$name}/',
        'profilefield'       => '{$prefix}{$public}user/profile/field/{$name}/',
        'qbank'              => '{$prefix}{$public}question/bank/{$name}/',
        'qbehaviour'         => '{$prefix}{$public}question/behaviour/{$name}/',
        'qformat'            => '{$prefix}{$public}question/format/{$name}/',
        'qtype'              => '{$prefix}{$public}question/type/{$name}/',
        'quiz'               => '{$prefix}{$public}mod/quiz/report/{$name}/',
        'quizaccess'         => '{$prefix}{$public}mod/quiz/accessrule/{$name}/',
        'report'             => '{$prefix}{$public}report/{$name}/',
        'repository'         => '{$prefix}{$public}repository/{$name}/',
        'scormreport'        => '{$prefix}{$public}mod/scorm/report/{$name}/',
        'search'             => '{$prefix}{$public}search/engine/{$name}/',
        'smsgateway'         => '{$prefix}{$public}sms/gateway/{$name}/',
        'theme'              => '{$prefix}{$public}theme/{$name}/',
        'tiny'               => '{$prefix}{$public}lib/editor/tiny/plugins/{$name}/',
        'tool'               => '{$prefix}{$public}admin/tool/{$name}/',
        'webservice'         => '{$prefix}{$public}webservice/{$name}/',
        'workshopallocation' => '{$prefix}{$public}mod/workshop/allocation/{$name}/',
        'workshopeval'       => '{$prefix}{$public}mod/workshop/eval/{$name}/',
        'workshopform'       => '{$prefix}{$public}mod/workshop/form/{$name}/',

        // Community plugin subplugin types.

        // mod_customcert subplugin types.
        'customcertelement'  => '{$prefix}{$public}mod/customcert/element/{$name}/',

        // tool_lifecycle subplugin types.
        'lifecycletrigger'   => '{$prefix}{$public}admin/tool/lifecycle/trigger/',
        'lifecyclestep'      => '{$prefix}{$public}admin/tool/lifecycle/step/',


        // Legacy plugin and subplugin types which may be installed manually.
        'atto'               => '{$prefix}{$public}lib/editor/atto/plugins/{$name}/',
        'assignment'         => '{$prefix}{$public}mod/assignment/type/{$name}/',
        'tinymce'            => '{$prefix}{$public}lib/editor/tinymce/plugins/{$name}/',
    ];

    /**
     * {@inheritDoc}
     */
    public function inflectPackageVars(array $vars): array
    {
        // Guess the package prefix and public directory.
        $vars['prefix'] = $this->getRootPackagePath();
        $vars['public'] = $this->getPublicPath();

        // Guess the name from the package name if not explicitly set.
        $matches = [];
        preg_match('/^moodle-(?<type>([^_]*))_(?<name>(.*))$/', $vars['name'], $matches);

        if ($matches) {
            $vars['name'] = $matches['name'];
        }

        return $vars;
    }

    /**
     * Get the install path for the root package.
     *
     * @return string
     */
    protected function getRootPackagePath(): string
    {
        // To allow for migration from the legacy way of doing things, we
        // check for an 'install-path' setting in the root package extra.
        // This allows the root package to put the Moodle installation in
        // a custom location.
        // If there is no such setting, we assume the root package is a
        // legacy package.
        $rootPackage = $this->composer->getPackage();

        $extra = $rootPackage->getExtra();
        return $extra['install-path'] ?? '';
    }

    /**
     * Determine if Moodle uses a public directory.
     *
     * @return string
     */
    protected function getPublicPath(): string
    {
        // The public directory setting is stored in the main Moodle package's.
        // Legacy Moodle installs do not have this path, or any setting.
        $moodlePackage = $this->composer->getRepositoryManager()->findPackage(
            'moodle/moodle',
            '*'
        );
        $extra = $moodlePackage ? $moodlePackage->getExtra() : $this->composer->getPackage()->getExtra();

        return !empty($extra['haspublicdir']) ? 'public/' : '';
    }
}
