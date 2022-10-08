import Router;
import php.Lib;

class Main {
    static public function main():Void {
        var r = new Router();

        php.Syntax.code('header("Access-Control-Allow-Origin: *");');
        php.Syntax.code('header("Access-Control-Allow-Headers: *");');
        php.Syntax.code('header("Access-Control-Allow-Methods: *");');

        r.registerPath("GET", "api/", function() {
            Lib.println(getFailCount());
            return;
        });

        r.registerPath("POST", "api/", function() {
            var pass = php.SuperGlobal._GET["pass"];
            var correct_pass = sys.io.File.getContent("../password.secret");

            if (pass == correct_pass) {
                incrementFailCount();
            }

            return;
        });

        r.run();
    }

    static private function getFailCount() {
        // Get text from appstate.json
        var appState = sys.io.File.getContent("../appstate.json");

        // Parse text to JSON
        var appStateJson = haxe.Json.parse(appState);

        // Return fails count
        return appStateJson.fails;
    }

    static private function incrementFailCount() {
        // Get text from appstate.json
        var appState = sys.io.File.getContent("../appstate.json");

        // Parse text to JSON
        var appStateJson = haxe.Json.parse(appState);

        // Increment fails count
        appStateJson.fails++;

        // Write JSON to appstate.json
        sys.io.File.saveContent("../appstate.json", haxe.Json.stringify(appStateJson));
    }
}