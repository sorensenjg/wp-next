import App from "./App";
import { render } from "@wordpress/element";
import "focus-visible/dist/focus-visible";
import "./assets/styles/global.scss";

render(<App />, document.getElementById("wp-next"));
