import php.Lib;
using StringTools;

class Router {
	private var path: String;
	private var has404: Bool;
	private var registeredPaths: Map<String, Void->Void>;

	public function new() {
		// Get whatever path was used in the route
        var get = Lib.hashOfAssociativeArray(php.SuperGlobal._GET);
		this.path = get.exists("path") ? get["path"] : null;

		this.has404 = false;
        this.registeredPaths = new Map<String, Void->Void>();
	}

	public function registerPath(method: String, path: String, callback: Void->Void) {
		if (method == php.SuperGlobal._SERVER["REQUEST_METHOD"]) {
            this.registeredPaths[path] = callback;
        }
	}

	public function notFound(callback: Void->Void) {
        this.registeredPaths["404"] = callback;
        this.has404 = true;
    }

    public function run() {
    	var found = false;

        // If path doesnt end with a /, add a /
        if (!this.path.endsWith('/')) {
            this.path = this.path + '/';
        }

        // Check if the path matches the registered path
        // and return the matching path
        for (registeredPath => callback in this.registeredPaths) {
            if (this.path == registeredPath) {
                callback();
                found = true;
                break;
            }
        }

        // If no path was found, call the not found callback
        if (!found && has404) {
            this.registeredPaths["404"]();
        }
    }
}