ng new [name]

Creates a new Angular workspace.

Arguments:
  name  The name of the new workspace and initial project.  [string]

Options:

      --help                Shows a help message for this command in the console.  [boolean]
                           
      --interactive         Enable interactive input prompts.  [boolean]
                            [default: true]

  -d, --dry-run             Run through and reports activity without writing out results.  [boolean]
                            [default: false]

      --defaults            Disable interactive input prompts for options with a default.  [boolean]
                            [default: false]

      --force               Force overwriting of existing files.  [boolean]
                            [default: false]

  -c, --collection          A collection of schematics to use in generating the initial application.  [string]

      --commit              Initial git repository commit information.  [boolean]
                            [default: true]

      --create-application  Create a new initial application project in the 'src' folder of the new workspace. When false, creates an empty workspace with no initial application. You can then use the generate application command so that all applications are created in the projects folder.  [boolean]
                            [default: true]

      --directory           The directory name to create the workspace in.  [string]

  -s, --inline-style        Include styles inline in the component TS file. By default, an external styles file is created and referenced in the component TypeScript file.  [boolean]
                           
  -t, --inline-template     Include template inline in the component TS file. By default, an external template file is created and referenced in the component TypeScript file.  [boolean]
                           

      --minimal             Create a workspace without any testing frameworks. (Use for learning purposes only.)  [boolean]
                            [default: false]

      --new-project-root    The path where new projects will be created, relative to the new workspace root.  [string]
                            [default: "projects"]

      --package-manager     The package manager used to install dependencies.  [string] [choices: "npm", "yarn", "pnpm", "cnpm", "bun"]
  -p, --prefix              The prefix to apply to generated selectors for the initial project.  [string]
                            [default: "app"]

      --routing             Enable routing in the initial project.  [boolean]
                           
  -g, --skip-git            Do not initialize a git repository.  [boolean]
                            [default: false]

      --skip-install        Do not install dependency packages.  [boolean]
                            [default: false]
  -S, --skip-tests          Do not generate "spec.ts" test files for the new project.  [boolean]
                            [default: false]

      --ssr                 Creates an application with Server-Side Rendering (SSR) and Static Site Generation (SSG/Prerendering) enabled.  [boolean]

      --standalone          Creates an application based upon the standalone API, without NgModules.  [boolean]
                            [default: true]

      --strict              Creates a workspace with stricter type checking and stricter bundle budgets settings. This setting helps improve maintainability and catch bugs ahead of time. For more information, see https://angular.dev/tools/cli/template-typecheck#strict-mode  [boolean]
                            [default: true]

      --style               The file extension or preprocessor to use for style files.  [string]
                            [choices: "css", "scss", "sass", "less"]

      --view-encapsulation  The view encapsulation strategy to use in the initial project.  [string]
                            [choices: "Emulated", "None", "ShadowDom"]
