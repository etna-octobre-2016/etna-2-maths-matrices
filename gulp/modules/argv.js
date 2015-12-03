var yargs = require("yargs");

// adds usage
yargs = yargs
    .usage("Usage: $0 <command> [options]")
    .command("build", "Builds distributable project in the dist/ directory.")
    .command("clean", "Removes dist/ and tmp/ directories")
    .command("dev", "Launches development environment.")
    .demand(1)
    .help("h")
    .alias("h", "help")
    .describe("env", "Sets target environment. Available values:\n- development\n- preprod\n- production")
    .nargs("env", 1);

// sets default values
yargs = yargs
    .default("env", "development");

// exports command args
module.exports = yargs.argv;
