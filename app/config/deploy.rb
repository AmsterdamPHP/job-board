set :application, "AmsterdamPHP Job Board"
set :domain,      "jobs.amsterdamphp.nl"
set :deploy_to,   "/data/www/#{domain}"
set :app_path,    "app"

set :repository,  "git://github.com/AmsterdamPHP/job-board.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,  3

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

default_run_options[:pty] = true
set :use_sudo, false